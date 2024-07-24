<?php

namespace App\Imports;

use App\Models\BayiModel;
use App\Models\FormatAModel;
use App\Models\OrangTuaModel;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Log;

class FormatAImport implements ToCollection
{
    function parseDate($dateString, $namaColumn = "")
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
            'Y-m-d',
            'Y/m/d',
            'Y m d',
        ];

        foreach ($formats as $format) {
            try {
                return Carbon::createFromFormat($format, $dateString)->format('Y-m-d');
            } catch (\Exception $e) {
                // Continue trying next format
            }
        }

        // Log the problematic date string
        Log::error('Format tanggal tidak sesuai: ' . $dateString);

        throw new \Exception('Format ' . $namaColumn . ' tidak sesuai:' . $dateString);
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        // Skip the first 4 rows and start from row 5
        $collection = $collection->slice(4);

        $errors = [];

        foreach ($collection as $index => $data) {
            try {
                // Ensure data fields are set before parsing
                $tanggal_lahir = isset($data[7]) ? $this->parseDate($data[7], "Tanggal Lahir") : null;
                $tanggal_meninggal_bayi = isset($data[8]) ? $this->parseDate($data[8], "Tanggal Meninggal Bayi") : null;
                $tanggal_meninggal_ibu = isset($data[9]) ? $this->parseDate($data[9], "Tanggal Meninggal Ibu") : null;

                // Check if parent data already exists by NIK
                $orangTua = null;

                if (!empty($data[1]) || !empty($data[3])) {
                    $orangTuaQuery = OrangTuaModel::query();

                    if (!empty($data[1])) {
                        $orangTuaQuery->where('nik_ayah', $data[1]);
                    }
                    if (!empty($data[3])) {
                        $orangTuaQuery->orWhere('nik_ibu', $data[3]);
                    }

                    $orangTua = $orangTuaQuery->first();
                }

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

                // Check if baby with same name and birth date already exists in the family
                $existingBayi = BayiModel::where('id_orang_tua', $orangTua->id)
                    ->where('nama', $data[4])
                    ->whereDate('tanggal_lahir', $tanggal_lahir)
                    ->first();

                if ($existingBayi) {
                    throw new \Exception("Data bayi ini sudah ditambahkan sebelumnya");
                }

                // Create a new baby record
                $bayi = BayiModel::create([
                    'id_orang_tua' => $orangTua->id,
                    'nama' => $data[4],
                    'jenis_kelamin' => $data[5],
                    'memiliki_kms' => $data[11],
                    'memiliki_kia' => $data[12],
                    'tanggal_lahir' => $tanggal_lahir,
                    'tanggal_meninggal' => $tanggal_meninggal_bayi,
                ]);

                // Create a new FormatA record
                FormatAModel::create([
                    'id_admin' => Auth::user()->id,
                    'id_bayi' => $bayi->id,
                    'keterangan' => $data[13]
                ]);

            } catch (\Exception $e) {
                // Log error
                Log::error('Baris ' . ($index + 1) . ' Error: ' . $e->getMessage());
                $errors[] = [
                    'baris' => $index + 1, // Adjust row number to account for skipped rows
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
