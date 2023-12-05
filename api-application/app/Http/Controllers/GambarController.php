<?php

namespace App\Http\Controllers;

use App\Http\Requests\GambarRequest;
use App\Models\GambarModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Carbon;

class GambarController extends Controller
{
    //
    public function get(GambarRequest $request): JsonResponse
    {

        /**
         * Mengambil dan memeriksa data request
         * 
         */
        $data = $request->validated();

        /**
         * Membuat query dasar untuk dijadikan
         * query utama dalam mengambil data
         * 
         */
        $query = GambarModel::select(
            'gambar.id as id_gambar',
            'admin.nama_lengkap',
            'gambar.gambar',
        )->join('admin', 'admin.id', '=', 'gambar.id_admin')
            ->orderByDesc('gambar.created_at');

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

            /**
             * Mengambil data gambar dari
             * query yang sudah difilter
             * 
             */
            $gambar = $query
                ->offset(($data['start'] - 1) * $data['length'])
                ->limit($data['length']);

        }

        /**
         * Mengambil data dari query dan
         * akan dijadikan response
         * 
         */
        $gambar = $query->get();

        /**
         * Menyesuaikan data
         * 
         */
        $gambar = $gambar->map(function ($result) {

            /**
             * Mengubah tanggal dan waktu menjadi hanya tanggal saja
             * tt-bb-hh jj:mm:dd -> tt-bb-hh
             * 
             */
            $result->tanggal = explode(' ', $result->tanggal)[0];
            return $result;

        });

        /**
         * Memeriksa apakah id_gambar ada
         * 
         */
        if (!empty($data['id_gambar'])) {

            /**
             * Mengambil query data sesuai id
             * 
             */
            $query = $query->where('id', $data['id_gambar']);

            /**
             * Mengambil data dari query dan
             * akan dijadikan response
             * 
             */
            $count = $query->count();
            $gambar = $query->first();

            /**
             * Mengubah tanggal dan waktu menjadi hanya tanggal saja
             * tt-bb-hh jj:mm:dd -> tt-bb-hh
             * 
             */
            $gambar->tanggal = explode(' ', $gambar->tanggal)[0];

        }

        /**
         * Mengembalikan response sesuai request
         */
        return response()->json([
            'gambar' => $gambar,
            'jumlah_data' => $count
        ])->setStatusCode(200);
    }
    public function post(GambarRequest $request): JsonResponse
    {

        /**
         * Memeriksa apakah request sesuai
         * dengan ketentuan berlaku
         * 
         */
        $data = $request->validated();

        /**
         * Memeriksa apakah request gambar ada
         * 
         */
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
        GambarModel::create($data);

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
    public function delete(GambarRequest $request): JsonResponse
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
        $edukasi = GambarModel::where('id', $data['id_gambar']);

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
