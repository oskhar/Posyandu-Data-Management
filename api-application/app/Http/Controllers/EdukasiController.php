<?php

namespace App\Http\Controllers;

use App\Http\Requests\EdukasiRequest;
use App\Models\EdukasiModel;
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
        $edukasi = EdukasiModel::select(
            'edukasi.id as id_edukasi',
            'admin.email_admin',
            'admin.nama_lengkap',
            'edukasi.judul',
            'edukasi.materi',
            'edukasi.gambar',
            'edukasi.created_at as tanggal'
        )->join('admin', 'admin.id', '=', 'edukasi.id_admin');

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
            $edukasi = $edukasi->where('judul', 'LIKE', '%' . $data['search'] . '%');

        }
        if (!empty($data['id_berita'])) {

            /**
             * Mengambil data dari query
             * 
             */
            $edukasi = $edukasi->where('id', $data['id_berita'])
                ->first();

        } else {

            /**
             * Mengambil data dari query
             * 
             */
            $edukasi = $edukasi->get();

        }

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
            return $result;

        });

        /**
         * Memeberikan data yang diminta
         * melalui response
         * 
         */
        return response()->json(
            $edukasi
        )->setStatusCode(200);
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
            $data['gambar'] = $path;
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
         * Mendapatkan data tujuan yang ingin
         * diupdate menggunakan id request
         * 
         */
        $edukasi = EdukasiModel::where('id', $data['id_edukasi']);
        unset($data['id_edukasi']);

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

            $namaFile = $edukasi->id_admin . Carbon::now()->format('Y-m-d') . '_' . time() . '.' . $extension;

            /**
             * Simpan gambar ke folder
             * 
             */
            $path = 'images/upload/' . $namaFile;
            $img->save(public_path($path), 80);
            $data['gambar'] = $path;
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
