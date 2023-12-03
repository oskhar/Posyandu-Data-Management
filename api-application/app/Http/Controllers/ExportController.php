<?php

namespace App\Http\Controllers;

use App\Exports\FormatAExport;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Response;

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
    public function exportFormatAExcel()
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
        return Excel::download(new FormatAExport, $namaFileExcel);
    }
}
