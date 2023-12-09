<?php

namespace App\Imports;

use App\Models\BayiModel;
use App\Models\FormatAModel;
use App\Models\OrangTuaModel;
use Illuminate\Http\Exceptions\HttpResponseException;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class FormatAImport implements ToModel, WithStartRow
{
    /**
     * Menentukan baris pertama yang
     * akan dibaca terlebih dahulu
     * 
     */
    public function startRow(): int
    {
        /**
         * Mulai membaca dari baris ke 5
         * 
         */
        return 5;
    }

    /**
     * Mengubah data excel ke dalam
     * data table dari database
     * 
     */
    public function model(array $row)
    {
        /**
         * Memeriksa apakah id bayi ada
         */
        if (empty($row['id_bayi'])) {

            /**
             * Memeriksa apakah data yang
             * dibutuhkan sudah tersedia
             * 
             */
            if (empty($row['nama_ibu']) || empty($row['nama_bayi'])) {
                throw new HttpResponseException(response()->json([
                    'errors' => [
                        'message' => 'Data nama_ibu atau nama_bayi tidak boleh kosong'
                    ]
                ])->setStatusCode(400));
            }

            /**
             * Melakukan penambahan data orang_tua
             * 
             */
            $orangTua = OrangTuaModel::create([
                'nama_ibu' => $row['nama_ibu'],
                'nama_ayah' => $row['nama_ayah'],
                'tanggal_meninggal_ibu' => $row['tanggal_meninggal_ibu'],
            ]);

            /**
             * Melakukan penambahan data bayi
             * 
             */
            $bayi = BayiModel::create([
                'id_orang_tua' => $orangTua->id,
                'nama' => $row['nama_bayi'],
                'jenis_kelamin' => $row['jenis_kelamin'],
                'tanggal_lahir' => $row['tanggal_lahir'],
                'tanggal_meninggal' => $row['tanggal_meninggal_bayi'],
            ]);
        }

        /**
         * Melakukan penambahan data format_a
         * 
         */
        FormatAModel::create([
            'id_bayi' => $row['id_bayi'] ?? $bayi->id,
            'keterangan' => $row['keterangan'],
        ]);
    }
}