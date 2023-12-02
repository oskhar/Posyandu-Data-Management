<?php

namespace App\Http\Controllers;

use App\Http\Requests\GambarRequest;
use App\Models\GambarModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
            'admin.email_admin',
            'admin.nama_lengkap',
            'gambar.gambar',
            'gambar.created_at as tanggal'
        )->join('admin', 'admin.id', '=', 'gambar.id_admin');

        /**
         * Mengambil banyaknya data yang diambil
         * 
         */
        $count = $query->count();

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
            return $gambar;

        } else {

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

        }

        /**
         * Mengembalikan response sesuai request
         */
        return response()->json([
            'gambar' => $gambar,
            'jumlah_data' => $count
        ])->setStatusCode(200);
    }
}
