<?php

namespace App\Http\Controllers;

use App\Imports\FormatAImport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function importFormatA(Request $request): JsonResponse
    {
        /**
         * Memasukan request ke dalam variabel
         * 
         */
        $file = $request->file('excel_file');

        /**
         * Memeriksa kelengkapan data
         * 
         */
        if (!$file) {
            return response()->json([
                'error' => 'Data tidak lengkap.'
            ])->setStatusCodtidake(400);
        }

        try {

            /**
             * Memanggil class import
             * 
             */
            $formatAImport = new FormatAImport();

            /**
             * Melakukan import data excel
             * 
             */
            Excel::import($formatAImport, $file);

            /**
             * Mengembalikan response jika proses
             * import berhasil dilakukan
             * 
             */
            return response()->json([
                'success' => [
                    "message" => "Data berhasil diimport"
                ]
            ])->setStatusCode(200);

        } catch (\Exception $e) {

            /**
             * Memberikan pesan dari kesalahan yang terjadi
             * ketika melakukan peng-import-an data
             * 
             */
            return response()->json([
                'error' => 'Terjadi kesalahan saat mengimpor data.'
            ])->setStatusCode(500);
        }
    }
}
