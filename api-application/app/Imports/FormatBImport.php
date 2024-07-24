<?php

namespace App\Imports;

use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;

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
