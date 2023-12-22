<?php

namespace App\Http\Controllers;

use App\Http\Requests\EdukasiRequest;
use App\Models\EdukasiModel;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Carbon;

class EdukasiController extends Controller
{
    //
    public function get(EdukasiRequest $request): JsonResponse
    {
        /**
         * Melakukan validasi apakah request
         * yang diberikan sudah sesuai
         * 
         */
        $data = $request->validated();

        /**
         * Membuat query dasar
         * 
         */
        $query = EdukasiModel::select(
            'edukasi.id as id_edukasi',
            'admin.email_admin',
            'admin.nama_lengkap',
            'edukasi.judul',
            'edukasi.materi',
            'edukasi.gambar',
            'edukasi.created_at as tanggal'
        )->join('admin', 'admin.id', '=', 'edukasi.id_admin')
            ->orderByDesc('edukasi.created_at');


        /**
         * Langsung mengembalikan data response
         * jika request id terdeteksi
         * 
         */
        if (!empty($data['id_edukasi'])) {

            /**
             * Mengambil query data sesuai id
             * 
             */
            $query = $query->where('edukasi.id', $data['id_edukasi']);

            /**
             * Mengambil data dari query dan
             * akan dijadikan response
             * 
             */
            $edukasi = $query->first();

            /**
             * Mengubah tanggal dan waktu menjadi hanya tanggal saja
             * tt-bb-hh jj:mm:dd -> tt-bb-hh
             * 
             */
            $edukasi->tanggal = explode(' ', $edukasi->tanggal)[0];
            $edukasi->overview = strlen($edukasi->materi) > 35 ? substr($edukasi->materi, 0, 35) . ".." : $edukasi->materi;

            /**
             * Mengembalikan nilai yang diminta
             * sesuai request yang diberikan
             * 
             */
            return response()->json(
                $edukasi
            )->setStatusCode(200);
        }

        /**
         * Melakukan filtering atau penyaringan
         * data pada kondisi tertentu
         * 
         */
        if (!empty($data['search'])) {

            /**
             * Memfilter data sesuai request search
             * 
             */
            $query = $query->where('edukasi.judul', 'LIKE', '%' . $data['search'] . '%');

        }

        /**
         * Mengambil banyaknya data yang diambil
         * 
         */
        $count = $query->count();

        /**
         * Memeriksa apakah data ingin difilter
         * 
         */
        if (isset($data['start']) && isset($data['length'])) {
            $query = $query->offset(($data['start'] - 1) * $data['length'])
                ->limit($data['length']);
        }

        /**
         * Mengambil data dari query dan
         * akan dijadikan response
         * 
         */
        $edukasi = $query->get();

        /**
         * Menyesuaikan data
         * 
         */
        $edukasi = $edukasi->map(function ($result) {

            /**
             * Mengubah tanggal dan waktu menjadi hanya tanggal saja
             * tt-bb-hh jj:mm:dd -> tt-bb-hh
             * 
             */
            $result->tanggal = explode(' ', $result->tanggal)[0];
            $result->overview = strlen($result->materi) > 35 ? substr($result->materi, 0, 35) . ".." : $result->materi;
            return $result;

        });

        /**
         * Memeberikan data yang diminta
         * melalui response
         * 
         */
        return response()->json([
            'jumlah_data' => $count,
            'edukasi' => $edukasi,
        ])->setStatusCode(200);
    }

    public function post(EdukasiRequest $request): JsonResponse
    {
        /**
         * Memeriksa apakah request sesuai
         * dengan ketentuan berlaku
         * 
         */
        $data = $request->validated();

        if (!empty($data['gambar'])) {
            /**
             * 'upload' adalah subfolder tempat gambar akan disimpan
             * di sistem penyimpanan yang Anda konfigurasi
             */
            $base64Parts = explode(",", $data['gambar']);
            $base64Image = end($base64Parts);

            $decodedImage = base64_decode($base64Image);

            /**
             * Membuat instance Intervention Image
             * 
             */
            $img = Image::make($decodedImage);

            /**
             * Tentukan ekstensi yang diinginkan
             * (jpg, jpeg, atau png)
             * 
             */
            $extension = 'jpg';

            /**
             * Mengidentifikasi tipe MIME gambar
             * 
             */
            $mime = finfo_buffer(finfo_open(), $decodedImage, FILEINFO_MIME_TYPE);

            /**
             * Jika tipe MIME adalah gambar JPEG, 
             * maka set ekstensi menjadi 'jpg'
             * 
             */
            if ($mime === 'image/jpeg') {
                $extension = 'jpeg';
            }

            /**
             * Jika tipe MIME adalah gambar PNG,
             * maka set ekstensi menjadi 'png'
             * 
             */
            if ($mime === 'image/png') {
                $extension = 'png';
            }

            $namaFile = $data['id_admin'] . Carbon::now()->format('Y-m-d') . '_' . time() . '.' . $extension;

            /**
             * Simpan gambar ke folder
             * 
             */
            $path = 'images/upload/' . $namaFile;
            $img->save(public_path($path), 80);
            $data['gambar'] = '/' . $path;
        }

        /**
         * Melakukan penambahan data ke database
         * 
         */
        EdukasiModel::create($data);

        /**
         * Mengembalikan response setelah
         * melakukan penambahan data
         * 
         */
        return response()->json([
            'success' => [
                'message' => "Data edukasi berhasil ditambahkan"
            ]
        ])->setStatusCode(201);
    }

    public function put(EdukasiRequest $request): JsonResponse
    {
        /**
         * Memeriksa apakah request
         * sesuai dengan ketentua
         * 
         */
        $data = $request->validated();

        /**
         * Memeriksa apakah request judul kosong
         * 
         */
        if (!empty($data['judul'])) {
            if ($data['judul'] == "") {

                throw new HttpResponseException(response()->json([
                    'errors' => [
                        'message' => 'Judul tidak boleh kosong'
                    ]
                ])->setStatusCode(401));

            }
        }

        /**
         * Mendapatkan data tujuan yang ingin
         * diupdate menggunakan id request
         * 
         */
        $edukasi = EdukasiModel::where('id', $data['id_edukasi'])->first();
        unset($data['id_edukasi']);

        if (!empty($data['gambar']) && $edukasi->gambar != $data['gambar']) {
            /**
             * 'upload' adalah subfolder tempat gambar akan disimpan
             * di sistem penyimpanan yang Anda konfigurasi
             */
            $base64Parts = explode(",", $data['gambar']);
            $base64Image = end($base64Parts);

            $decodedImage = base64_decode($base64Image);

            /**
             * Membuat instance Intervention Image
             * 
             */
            $img = Image::make($decodedImage);

            /**
             * Tentukan ekstensi yang diinginkan
             * (jpg, jpeg, atau png)
             * 
             */
            $extension = 'jpg';

            /**
             * Mengidentifikasi tipe MIME gambar
             * 
             */
            $mime = finfo_buffer(finfo_open(), $decodedImage, FILEINFO_MIME_TYPE);

            /**
             * Jika tipe MIME adalah gambar JPEG, 
             * maka set ekstensi menjadi 'jpg'
             * 
             */
            if ($mime === 'image/jpeg') {
                $extension = 'jpeg';
            }

            /**
             * Jika tipe MIME adalah gambar PNG,
             * maka set ekstensi menjadi 'png'
             * 
             */
            if ($mime === 'image/png') {
                $extension = 'png';
            }

            $namaFile = $edukasi->id_admin . Carbon::now()->format('Y-m-d') . '_' . time() . '.' . $extension;

            /**
             * Simpan gambar ke folder
             * 
             */
            $path = 'images/upload/' . $namaFile;
            $img->save(public_path($path), 80);
            $data['gambar'] = '/' . $path;
        }

        /**
         * Melakukan update data
         * 
         */
        $edukasi->update($data);

        /**
         * Mengembalikan response setelah
         * melakukan update data
         * 
         */
        return response()->json([
            'success' => [
                'message' => "Data edukasi berhasil diubah"
            ]
        ])->setStatusCode(201);
    }

    public function delete(EdukasiRequest $request): JsonResponse
    {
        /**
         * Memeriksa apakah request
         * yang diberikan sesuai
         * 
         */
        $data = $request->validated();

        /**
         * Mendapatkan data yang dituju
         * menggunakan request id
         * 
         */
        $edukasi = EdukasiModel::where('id', $data['id_edukasi']);

        /**
         * Melakukan penghapusan data
         * 
         */
        $edukasi->delete();

        /**
         * Mengembalikan response setelah
         * melakukan delete data
         * 
         */
        return response()->json([
            'success' => [
                'message' => "Data edukasi berhasil dihapus"
            ]
        ])->setStatusCode(200);
    }
}
