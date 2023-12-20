<?php

namespace App\Http\Controllers;

use App\Http\Requests\PosyanduRequest;
use App\Models\AdminModel;
use App\Models\PosyanduModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Carbon;

class PosyanduController extends Controller
{
    //
    public function get(): JsonResponse
    {
        /**
         * Mengambil data posyandu
         * 
         */
        $posyandu = PosyanduModel::select(
            'nama_posyandu',
            'kota',
            'kecamatan',
            'kelurahan',
            'penyampaian_ketua',
            'gambar_gedung',
            'visi',
            'misi',
            'rt_rw'
        )->first();

        /**
         * Mengambil foto_profile ketua
         * 
         */
        $posyandu->foto_profile_ketua = AdminModel::select('foto_profile', 'nama_lengkap', 'id_jabatan')
            ->orderBy('id_jabatan')
            ->first()
            ->foto_profile;

        /**
         * Memeberikan data yang diminta
         * melalui response
         * 
         */
        return response()->json(
            $posyandu
        )->setStatusCode(200);
    }

    public function put(PosyanduRequest $request): JsonResponse
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
        $posyandu = PosyanduModel::first();

        if (!empty($data['gambar_gedung']) && $posyandu->gambar_gedung != $data['gambar_gedung']) {
            /**
             * 'upload' adalah subfolder tempat gambar akan disimpan
             * di sistem penyimpanan yang Anda konfigurasi
             */
            $base64Parts = explode(",", $data['gambar_gedung']);
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

            $namaFile = Carbon::now()->format('Y-m-d') . '_' . time() . '.' . $extension;

            /**
             * Simpan gambar ke folder
             * 
             */
            $path = 'images/upload/' . $namaFile;
            $img->save(public_path($path), 80);
            $data['gambar_gedung'] = '/' . $path;
        }

        /**
         * Melakukan update data
         * 
         */
        $posyandu->update($data);

        /**
         * Mengembalikan response setelah
         * melakukan update data
         * 
         */
        return response()->json([
            'success' => [
                'message' => "Data edukasi berhasil diubah"
            ],
        ])->setStatusCode(201);
    }
}
