<?php

namespace App\Imports;

use App\Models\BayiModel;
use App\Models\FormatAModel;
use App\Models\OrangTuaModel;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

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

        // Validate all dates first
        foreach ($collection as $data) {
            try {
                $tanggal_lahir = $this->parseDate($data[6]);
                $tanggal_meninggal_bayi = isset($data[7]) ? $this->parseDate($data[7]) : null;
                $tanggal_meninggal_ibu = isset($data[8]) ? $this->parseDate($data[8]) : null;

                $orangTua = OrangTuaModel::create([
                    'nama_ayah' => $data[0],
                    'nik_ayah' => $data[1],
                    'nama_ibu' => $data[2],
                    'nik_ibu' => $data[3],
                    'tanggal_meninggal_ibu' => $tanggal_meninggal_ibu,
                ]);

                $bayi = BayiModel::create([
                    'nama' => $data[4],
                    'jenis_kelamin' => $data[5],
                    'tanggal_lahir' => $tanggal_lahir,
                    'tanggal_meninggal' => $tanggal_meninggal_bayi,
                ]);

                FormatAModel::create([
                    'id_orang' => $orangTua->id,
                    'id_bayi' => $bayi->id,
                    'keterangan' => $data[9]
                ]);
            } catch (\Exception $e) {
                throw new HttpResponseException(response()->json([
                    'errors' => [
                        'message' => 'Format tanggal tidak sesuai!',
                        'permitted_dates' => [
                            '20-12-1998',
                            '20-Oct-1998',
                            '20-12-98',
                            '20-Oct-98',
                            '20/12/1998',
                            '20/Oct/1998',
                            '20/12/98',
                            '20/Oct/98',
                            '20 12 1998',
                            '20 Oct 1998',
                            '20 12 98',
                            '20 Oct 98'
                        ]
                    ]
                ]));
            }
        }
    }
}
