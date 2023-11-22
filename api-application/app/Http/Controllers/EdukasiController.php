<?php

namespace App\Http\Controllers;

use App\Http\Requests\EdukasiRequest;
use App\Models\EdukasiModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
            'admin.email_admin',
            'admin.nama_lengkap',
            'edukasi.judul',
            'edukasi.materi',
            'edukasi.gambar',
            'edukasi.created_at as tanggal'
        )->join('admin', 'admin.id', '=', 'edukasi.id_admin');

        /**
         * Mendapatkan data yang sudah
         * melalui tahap filtering
         * 
         */
        $edukasi = $edukasi->get();

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
