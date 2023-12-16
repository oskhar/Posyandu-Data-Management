<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormatBARequest;
use App\Models\BayiModel;
use App\Models\OrangTuaModel;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FormatBAController extends Controller
{
    protected $judulFormat = 'Regrister bayi (0 - 5 bulan) dalam wilayah kerja posyandu Januari - Desember';
    public function get(FormatBARequest $request): JsonResponse
    {
        /**
         * Melakukan validasi data request
         * 
         */
        $data = $request->validated();

        /**
         * Memeriksa apakah data id_bayi ada
         * 
         */
        if (!empty($data['id_bayi'])) {
            $bayi = BayiModel::select(
                'bayi.id as id_bayi',
                'bayi.nama as nama_bayi',
                'bayi.jenis_kelamin',
                'format_b.keterangan',
                'penimbangan.berat_badan',
                'penimbangan.ntob',
                'penimbangan.asi_ekslusif',
                'bayi.tanggal_lahir'
            )
                ->selectRaw('(' . $data['tahun'] . ' - YEAR(bayi.tanggal_lahir)) * 12 + ' . $data['bulan'] . ' - MONTH(bayi.tanggal_lahir) as umur')
                ->leftJoin('format_b', function ($join) {
                    $join->on('bayi.id', '=', 'format_b.id_bayi');
                })
                ->leftJoin('penimbangan', function ($join) use ($data) {
                    $join->on('bayi.id', '=', 'penimbangan.id_bayi')
                        ->whereRaw($data['bulan'] . ' - MONTH(bayi.tanggal_lahir) BETWEEN 0 AND 5');
                })
                ->whereRaw('(' . $data['tahun'] . ' - YEAR(bayi.tanggal_lahir)) * 12 + ' . $data['bulan'] . ' - MONTH(bayi.tanggal_lahir) BETWEEN 0 AND 5')
                ->whereNull('bayi.tanggal_meninggal')
                ->first();
        }

        /**
         * Membuat query utama
         * 
         */
        $query = BayiModel::select(
            'bayi.id as id_bayi',
            'bayi.nama as nama_bayi',
            'bayi.jenis_kelamin',
            'format_b.keterangan',
            'penimbangan.berat_badan',
            'penimbangan.ntob',
            'penimbangan.asi_ekslusif',
            'bayi.tanggal_lahir'
        )
            ->selectRaw('(' . $data['tahun'] . ' - YEAR(bayi.tanggal_lahir)) * 12 + ' . $data['bulan'] . ' - MONTH(bayi.tanggal_lahir) as umur')
            ->leftJoin('format_b', function ($join) {
                $join->on('bayi.id', '=', 'format_b.id_bayi');
            })
            ->leftJoin('penimbangan', function ($join) use ($data) {
                $join->on('bayi.id', '=', 'penimbangan.id_bayi')
                    ->whereRaw($data['bulan'] . ' - MONTH(bayi.tanggal_lahir) BETWEEN 0 AND 5');
            })
            ->whereRaw('(' . $data['tahun'] . ' - YEAR(bayi.tanggal_lahir)) * 12 + ' . $data['bulan'] . ' - MONTH(bayi.tanggal_lahir) BETWEEN 0 AND 5')
            ->whereNull('bayi.tanggal_meninggal');

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
            $query = $query->where('bayi.nama', 'LIKE', '%' . $data['search'] . '%');

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

            /**
             * Mengambil data gambar dari
             * query yang sudah difilter
             * 
             */
            $query = $query
                ->offset(($data['start'] - 1) * $data['length'])
                ->limit($data['length']);

        }

        /**
         * Mengambil data dari query dan
         * akan dijadikan response
         * 
         */
        $formatBA = $query->get();

        /**
         * Memeriksa apakah id_format_a ada
         * 
         */
        if (!empty($data['id_format_a'])) {

            /**
             * Mengambil query data sesuai id
             * 
             */
            $query = $query->where('format_a.id', $data['id_format_a']);

            /**
             * Mengambil data dari query dan
             * akan dijadikan response
             * 
             */
            $count = $query->count();
            $formatBA = $query->first();

        }


        /**
         * Memasukan data penimbangan
         */

        /**
         * Mengembalikan response sesuai request
         * 
         */
        return response()->json([
            "jumlah_data" => $count,
            "format_ba" => $formatBA
        ])->setStatusCode(200);
    }
}