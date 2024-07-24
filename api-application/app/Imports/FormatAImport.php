<?php

namespace App\Imports;

use App\Models\BayiModel;
use App\Models\FormatAModel;
use App\Models\OrangTuaModel;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Log;

class FormatAImport implements ToCollection
{
    function parseDate($dateString)
    {
        $formats = [
            'd-m-Y',
            'd-M-Y',
            'd-m-y',
            'd-M-y',
            'd/m/Y',
            'd/M/Y',
            'd/m/y',
            'd/M/y',
            'd m Y',
            'd M Y',
            'd m y',
            'd M y',
        ];

        foreach ($formats as $format) {
            try {
                return Carbon::createFromFormat($format, $dateString);
            } catch (\Exception $e) {
                // Continue trying next format
            }
        }

        throw new \Exception('Invalid date format');
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        // Skip the first 4 rows and start from row 5
        $collection = $collection->slice(4);

        $errors = [];

        // Validate all dates first
        foreach ($collection as $index => $data) {
            try {
                // Ensure data fields are set before parsing
                $tanggal_lahir = isset($data[6]) ? $this->parseDate($data[6]) : null;
                $tanggal_meninggal_bayi = isset($data[7]) ? $this->parseDate($data[7]) : null;
                $tanggal_meninggal_ibu = isset($data[8]) ? $this->parseDate($data[8]) : null;

                // Check if parent data already exists by NIK
                $orangTua = OrangTuaModel::where('nik_ayah', $data[1])
                    ->orWhere('nik_ibu', $data[3])
                    ->first();

                if (!$orangTua) {
                    // If no match by NIK, check by parents' names
                    $orangTua = OrangTuaModel::where('nama_ayah', $data[0])
                        ->where('nama_ibu', $data[2])
                        ->first();

                    if (!$orangTua) {
                        // If no match by names, create a new parent record
                        $orangTua = OrangTuaModel::create([
                            'nama_ayah' => $data[0],
                            'nik_ayah' => $data[1],
                            'nama_ibu' => $data[2],
                            'nik_ibu' => $data[3],
                            'tanggal_meninggal_ibu' => $tanggal_meninggal_ibu,
                        ]);
                    }
                }

                // Create a new baby record
                $bayi = BayiModel::create([
                    'nama' => $data[4],
                    'jenis_kelamin' => $data[5],
                    'tanggal_lahir' => $tanggal_lahir,
                    'tanggal_meninggal' => $tanggal_meninggal_bayi,
                ]);

                // Create a new FormatA record
                FormatAModel::create([
                    'id_orang' => $orangTua->id,
                    'id_bayi' => $bayi->id,
                    'keterangan' => $data[9]
                ]);

            } catch (\Exception $e) {
                // Log error
                Log::error('Row ' . ($index + 5) . ' Error: ' . $e->getMessage());
                $errors[] = [
                    'row' => $index + 5, // Adjust row number to account for skipped rows
                    'message' => $e->getMessage()
                ];
            }
        }

        if (!empty($errors)) {
            throw new HttpResponseException(response()->json([
                'errors' => $errors
            ])->setStatusCode(422));
        }
    }
}
