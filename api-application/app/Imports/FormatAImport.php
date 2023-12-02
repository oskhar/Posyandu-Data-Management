<?php

namespace App\Imports;

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

    }
}