<?php

namespace App\Imports;

use App\Models\BayiModel;
use App\Models\OrangTuaModel;
use App\Models\PenimbanganModel;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;

class FormatBImport implements ToCollection
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
    {// Mengambil nilai tahun penimbangan dari koleksi
        $tahun_penimbangan = $collection->first()->first();

        // Memecah string berdasarkan spasi dan mengambil elemen terakhir
        $tahun_penimbangan_parts = explode(" ", $tahun_penimbangan);
        $tahun_penimbangan = end($tahun_penimbangan_parts);

        // Skip the first 4 rows and start from row 5
        $collection = $collection->slice(5);

        $errors = [];

        foreach ($collection as $index => $data) {
            try {
                $tanggal_lahir = isset($data[2]) ? $this->parseDate($data[2], "Tanggal Lahir") : null;
                $bayi = BayiModel::where("nama", $data[0])
                    ->where("tanggal_lahir", $tanggal_lahir)->first();

                if (!$bayi) {
                    throw new \Exception("Data bayi dengan nama {$data[0]} tidak ditemukan");
                }

                if (!empty($data[3]) && $bayi->berat_lahir != $data[3]) {
                    $bayi->update([
                        "berat_lahir" => $data[3]
                    ]);
                }

                $orang_tua = OrangTuaModel::find($bayi->id_orang_tua);

                if (!$orang_tua) {
                    throw new \Exception("Data orang tua dengan nama {$data[5]} & {$data[4]} tidak ditemukan");
                }

                if (!empty($data[6]) && $orang_tua->rt_rw != $data[6]) {
                    $orang_tua->update([
                        "rt_rw" => $data[6]
                    ]);
                }

                if (!empty($data[7]) && $bayi->memiliki_kms != $data[7]) {
                    $bayi->update([
                        "memiliki_kms" => $data[7]
                    ]);
                }

                if (!empty($data[8]) && $bayi->memiliki_kia != $data[8]) {
                    $bayi->update([
                        "memiliki_kia" => $data[8]
                    ]);
                }

                for ($i = 0; $i < 12; $i++) {
                    if (
                        is_numeric($data[9 + ($i * 3)]) &&
                        $data[9 + ($i * 3)] != "-" &&
                        $data[10 + ($i * 3)] != "-" &&
                        $data[11 + ($i * 3)] != "-" &&
                        isset($data[9 + ($i * 3)]) &&
                        isset($data[10 + ($i * 3)]) &&
                        isset($data[11 + ($i * 3)])
                    ) {
                        $id_standar_deviasi = DB::table('standar_deviasi')->where([
                            ['id_berat_untuk_umur', '=', $data[1] == 'L' ? 1 : 2],
                            ['umur_bulan', '=', $data[9 + ($i * 3)]],
                        ])->value('id');

                        PenimbanganModel::updateOrCreate([
                            "id_bayi" => $bayi->id,
                            "id_standar_deviasi" => $id_standar_deviasi,
                            "tahun_penimbangan" => $tahun_penimbangan
                        ], [
                            "bulan_penimbangan" => $i + 1,
                            "berat_badan" => $data[10 + ($i * 3)],
                            "ntob" => $data[11 + ($i * 3)],
                        ]);
                    }
                }

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
