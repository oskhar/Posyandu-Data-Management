<?php

namespace App\Imports;

use App\Models\BayiModel;
use App\Models\FormatAModel;
use App\Models\OrangTuaModel;
use Carbon\Carbon;
use DateTime;
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
            'm/d/Y',
            'm-d-Y',
            'j-m-Y',
            'j-M-Y',
            'j-m-y',
            'j-M-y',
            'j/m/Y',
            'j/M/Y',
            'j/m/y',
            'j/M/y',
            'j m Y',
            'j M Y',
            'j m y',
            'j M y',
            'Y-m-j',
            'Y/m/j',
            'Y m j',
            'm/j/Y',
            'm-j-Y',
        ];

        // Cek apakah $dateString adalah string angka yang seharusnya ditangani sebagai tanggal
        if (is_numeric($dateString)) {
            // Konversi serial number Excel ke tanggal
            $dateString = Carbon::createFromFormat('Y-m-d', '1899-12-30')->addDays($dateString)->format('Y-m-d');
        }

        foreach ($formats as $format) {
            try {
                $date = Carbon::createFromFormat($format, $dateString);
                return $date->format('Y-m-d');
            } catch (\Exception $e) {
            }
        }

        // Log the problematic date string
        Log::error("Format tanggal tidak sesuai: {$dateString}");
        throw new \Exception("Format {$namaColumn} {$dateString} tidak sesuai");
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
                $tanggal_lahir = isset($data[9]) ? $this->parseDate($data[9], "Tanggal Lahir") : null;
                $tanggal_meninggal_bayi = isset($data[10]) ? $this->parseDate($data[10], "Tanggal Meninggal Bayi") : null;
                $tanggal_meninggal_ibu = isset($data[11]) ? $this->parseDate($data[11], "Tanggal Meninggal Ibu") : null;
                // $tanggal_lahir = $data[9];
                // $tanggal_meninggal_bayi = $data[10];
                // $tanggal_meninggal_ibu = $data[11];

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
                            'nik_ayah' => ltrim($data[1], "'"),
                            'nama_ibu' => $data[2],
                            'nik_ibu' => ltrim($data[3], "'"),
                            'rt_rw' => $data[12],
                            'no_telp' => ltrim($data[16], "'"),
                            'tempat_tinggal' => $data[17],
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
                    'nik' => ltrim($data[5], "'"),
                    'jenis_kelamin' => $data[6],
                    'memiliki_kms' => $data[13],
                    'memiliki_kia' => $data[14],
                    'imd' => $data[15],
                    'berat_lahir' => $data[7],
                    'tinggi_lahir' => $data[8],
                    'tanggal_lahir' => $tanggal_lahir,
                    'tanggal_meninggal' => $tanggal_meninggal_bayi,
                ]);

                // Create a new FormatA record
                FormatAModel::create([
                    'id_admin' => Auth::user()->id,
                    'id_bayi' => $bayi->id,
                    'keterangan' => $data[18]
                ]);

            } catch (\Exception $e) {
                // Log error
                Log::error('Baris ' . ($index + 1) . ' Error: ' . $e->getMessage());
                $errors[] = $e->getMessage() . ' pada baris ' . $index + 1;
            }
        }

        if (!empty($errors)) {
            throw new HttpResponseException(response()->json([
                'errors' => $errors
            ])->setStatusCode(422));
        }
    }
}
