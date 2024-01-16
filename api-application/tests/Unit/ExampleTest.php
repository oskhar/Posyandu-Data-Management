<?php

namespace Tests\Unit;

use App\Models\BayiModel;
use Illuminate\Http\JsonResponse;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    protected $batasBulanStart = [0, 6, 12, 24];
    protected $batasBulanEnd = [5, 11, 23, 59];
    protected $namaBulan = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];
    /**
     * A basic test example.
     */
    public function apiTesting(): JsonResponse
    {
        $bulan = 1;
        $tahun = 2022;
        $tab = 0;
        $banyakBayi = BayiModel::whereRaw('(' . $tahun . ' - YEAR(bayi.tanggal_lahir)) * 12 + ' . $bulan . ' - MONTH(bayi.tanggal_lahir) BETWEEN ' . $this->batasBulanStart[$tab] . ' AND ' . $this->batasBulanEnd[$tab])
            ->count();

        /**
         * Mengembalikan response sesuai request
         * 
         */
        return response()->json([
            $banyakBayi
        ])->setStatusCode(200);
    }
}
