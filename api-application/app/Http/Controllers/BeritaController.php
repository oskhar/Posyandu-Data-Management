<?php

namespace App\Http\Controllers;

use App\Http\Requests\BeritaRequest;
use App\Models\BeritaModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Carbon;

class BeritaController extends Controller
{
    public function get(BeritaRequest $request): JsonResponse
    {
        /**
         * Melakukan pengecekan kesesuaian data
         * apakah data yang dikirim sesuai
         * dengan ketentuan yang berlaku
         * 
         */
        $data = $request->validated();

        /**
         * Membuat query dasar untuk dijadikan
         * tumpuan dalam pengambilan data
         * 
         */
        $berita = BeritaModel::select(
            'berita.id as id_berita',
            'admin.email_admin',
            'admin.nama_lengkap',
            'berita.judul',
            'berita.deskripsi',
            'berita.gambar',
            'berita.tanggal_pelaksanaan',
            'berita.created_at as tanggal'
        )->join('admin', 'admin.id', '=', 'berita.id_admin');

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
            $berita = $berita->where('judul', 'LIKE', '%' . $data['search'] . '%');

        }
        if (!empty($data['id_berita'])) {

            /**
             * Mengambil data dari query
             * 
             */
            $berita = $berita->where('id', $data['id_berita'])
                ->first();

        } else {

            /**
             * Mengambil data dari query
             * 
             */
            $berita = $berita->get();

        }

        /**
         * Menyesuaikan data
         * 
         */
        $berita = $berita->map(function ($result) {

            /**
             * Mengubah tanggal dan waktu menjadi hanya tanggal saja
             * tt-bb-hh jj:mm:dd -> tt-bb-hh
             * 
             */
            $result->tanggal = explode(' ', $result->tanggal)[0];
            return $result;

        });

        /**
         * Mengembalikan nilai yang diminta
         * sesuai request yang diberikan
         * 
         */
        return response()->json(
            $berita
        )->setStatusCode(200);
    }

    public function post(BeritaRequest $request): JsonResponse
    {
        /**
         * Melakukan validasi data request
         * apakah data sesuai ketentuan
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
         * Melakukan penambahan data
         * 
         */
        BeritaModel::create($data);

        /**
         * Mengembalikan response sesuai dengan
         * apa yang sudah dikerjakan server
         * 
         */
        return response()->json([
            'success' => [
                'message' => 'Data berita berhasil ditambahkan'
            ]
        ])->setStatusCode(201);
    }

    public function put(BeritaRequest $request): JsonResponse
    {
        /**
         * Memeriksa apakah data request
         * sesuai dengan ketentuan
         * 
         */
        $data = $request->validated();

        /**
         * Mengambil data yang ingin diubah
         * sesuai dengan id yang diberikan
         * 
         */
        $berita = BeritaModel::where('id', $data['id_berita'])->first();
        unset($data['id_berita']);

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

            $namaFile = $berita->id_admin . Carbon::now()->format('Y-m-d') . '_' . time() . '.' . $extension;

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
         * sesuai request
         * 
         */
        $berita->update($data);

        /**
         * Mengembalikan response sesuai dengan
         * apa yang sudah dikerjakan server
         * 
         */
        return response()->json([
            'success' => [
                'message' => 'Data berita berhasil diubah'
            ]
        ])->setStatusCode(201);
    }

    public function delete(BeritaRequest $request): JsonResponse
    {
        /**
         * Melakukan validasi apakah data
         * request yang diberikan sesuai
         * 
         */
        $data = $request->validated();

        /**
         * Mengambil data berita sesuai id
         * 
         */
        $berita = BeritaModel::where('id', $data['id_berita'])->first();

        /**
         * Melakukan delete data
         * 
         */
        $berita->delete();

        /**
         * Mengembalikan response sesuai dengan
         * apa yang sudah dikerjakan server
         * 
         */
        return response()->json([
            'success' => [
                'message' => 'Data berita berhasil dihapus'
            ]
        ])->setStatusCode(200);
    }
}
