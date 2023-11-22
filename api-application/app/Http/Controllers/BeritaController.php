<?php

namespace App\Http\Controllers;

use App\Http\Requests\BeritaRequest;
use App\Models\BeritaModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
            'admin.email_admin',
            'admin.nama_lengkap',
            'edukasi.judul',
            'edukasi.deskripsi',
            'edukasi.gambar',
            'edukasi.tanggal_pelaksanaan',
            'edukasi.created_at as tanggal'
        )->join('admin', 'admin.id', '=', 'edukasi.id_admin');

        /**
         * Melakukan filtering atau penyaringan
         * data pada kondisi tertentu
         * 
         */
        if ($data['id_berita']) {
            $berita = $berita->where('id', $data['id_berita']);
        }
        if ($data['search']) {
            $berita = $berita->where('judul', 'LIKE', '%' . $data['search'] . '%');
        }

        /**
         * Mengambil data dari query
         * 
         */
        $berita = $berita->get();

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
