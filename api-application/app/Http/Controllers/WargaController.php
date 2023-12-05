<?php

namespace App\Http\Controllers;

use App\Http\Requests\WargaRequest;
use App\Models\BayiModel;
use App\Models\OrangTuaModel;
use Illuminate\Http\JsonResponse;

class WargaController extends Controller
{
    //
    public function get(WargaRequest $request): JsonResponse
    {
        /**
         * Memeriksa validasi data request
         * 
         */
        $data = $request->validated();

        /**
         * Mempersiapkan query dasa untuk dijadikan
         * query utama dalam pengambilan data
         * 
         */
        $query = OrangTuaModel::select(
            'bayi.nama',
            'bayi.jenis_kelamin',
            'bayi.berat_lahir',
            'bayi.tanggal_lahir',
            'bayi.tanggal_meninggal',
            'orang_tua.nama_ayah',
            'orang_tua.nama_ibu',
            'orang_tua.tanggal_lahir_ibu',
            'orang_tua.tanggal_meninggal_ibu',
            'orang_tua.rt_rw',
            'orang_tua.wus_pus',
            'orang_tua.tahapan_ks',
            'orang_tua.memiliki_kms',
            'orang_tua.memiliki_kia'
        )->join('bayi', 'orang_tua.id', '=', 'bayi.id_orang_tua')
            ->orderByDesc('orang_tua.created_at');

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
            $query = $query->where('bayi.nama', 'LIKE', '%' . $data['search'] . '%')
                ->orWhere('orang_tua.nama_ibu', 'LIKE', '%' . $data['search'] . '%')
                ->orWhere('orang_tua.nama_ayah', 'LIKE', '%' . $data['search'] . '%');

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
            $warga = $query->offset(($data['start'] - 1) * $data['length'])
                ->limit($data['length']);
        }

        /**
         * Mengambil data dari query dan
         * akan dijadikan response
         * 
         */
        $warga = $query->get();

        if (!empty($data['id_warga'])) {

            /**
             * Mengambil query data sesuai id
             * 
             */
            $query = $query->where('orang_tua.id', $data['id_warga']);

            /**
             * Mengambil data dari query dan
             * akan dijadikan response
             * 
             */
            $count = 1;
            $warga = $query->first();

        }


        /**
         * Mengembalikan response sesuai dengan
         * filter dari request yang diberikan
         * 
         */
        return response()->json([
            'jumlah_data' => $count,
            'warga' => $warga,
        ])->setStatusCode(200);
    }
    public function post(WargaRequest $request): JsonResponse
    {
        /**
         * Memeriksa validasi request
         * 
         */
        $data = $request->validated();

        /**
         * Melakukan penambahan data orang tua
         * 
         */
        $orangTua = OrangTuaModel::create([
            'nama_ayah' => $data['nama_ayah'],
            'nama_ibu' => $data['nama_ibu'],
            'tanggal_lahir_ibu' => $data['tanggal_lahir_ibu'],
            'tanggal_meninggal_ibu' => $data['tanggal_meninggal_ibu'],
            'rt_rw' => $data['rt_rw'],
            'wus_pus' => $data['wus_pus'],
            'tahapan_ks' => $data['tahapan_ks'],
            'memiliki_kms' => $data['memiliki_kms'],
            'memiliki_kia' => $data['memiliki_kia'],
        ]);

        if (!empty($data['nama_bayi'])) {
            /**
             * Melakukan penambahan data bayi
             * 
             */
            BayiModel::create([
                'id_orang_tua' => $orangTua->id,
                'nama' => $data['nama_bayi'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'berat_lahir' => $data['berat_lahir'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'tanggal_meninggal' => $data['tanggal_meninggal'],
            ]);
        }

        /**
         * Mengembalikan response sesuai dengan
         * apa yang sudah dikerjakan server
         * 
         */
        return response()->json([
            'success' => [
                'message' => 'Data warga berhasil ditambahkan'
            ]
        ])->setStatusCode(201);
    }
    public function put(WargaRequest $request): JsonResponse
    {
        /**
         * Mengembalikan response sesuai dengan
         * apa yang sudah dikerjakan server
         * 
         */
        return response()->json([
            'success' => [
                'message' => 'Data warga berhasil diubah'
            ]
        ])->setStatusCode(201);
    }
}
