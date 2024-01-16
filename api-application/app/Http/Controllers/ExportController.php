<?php

namespace App\Http\Controllers;

use App\Exports\FormatAExport;
use App\Exports\FormatBAExport;
use App\Exports\LaporanBExport;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    protected $currentTime;

    public function __construct()
    {
        /**
         * Mendapatkan tanggal sekarang dengan
         * waktu dan zona waktu yang aktif
         */
        $now = Carbon::now();

        /**
         * Mendapatkan tanggal sekarang dalam format
         * tertentu (contoh: Y-m-d H-i-s)
         */
        $this->currentTime = $now->format('Y-m-d.H:i:s');
    }
    public function exportFormatAExcel(Request $request)
    {

        /**
         * Mengatur nama file excel yang akan diexport
         * 
         */
        $namaFileExcel = 'Format-1.' . $this->currentTime . '.xlsx';

        /**
         * Menggunakan Excel::download untuk menghasilkan response
         * 
         */
        return Excel::download(new FormatAExport($request->tahun), $namaFileExcel);
    }
    public function exportFormatBAExcel(Request $request)
    {

        /**
         * Mengatur nama file excel yang akan diexport
         * 
         */
        $namaFileExcel = 'Format-2.' . $this->currentTime . '.xlsx';

        /**
         * Menggunakan Excel::download untuk menghasilkan response
         * 
         */
        return Excel::download(new FormatBAExport($request->tahun, $request->tab), $namaFileExcel);
    }
    public function exportLaporanBAExcel(Request $request)
    {

        /**
         * Mengatur nama file excel yang akan diexport
         * 
         */
        $namaFileExcel = 'Laporan-2.' . $this->currentTime . '.xlsx';

        /**
         * Menggunakan Excel::download untuk menghasilkan response
         * 
         */
        return Excel::download(new LaporanBExport($request->tahun, $request->bulan), $namaFileExcel);
    }
}
