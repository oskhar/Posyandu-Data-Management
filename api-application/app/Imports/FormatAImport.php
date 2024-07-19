<?php

namespace App\Imports;

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
            'd M y'
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
        // Validate all dates first
        foreach ($collection as $data) {
            try {
                // Assuming the date is in the second column (index 1)
                $this->parseDate($data[1]);
            } catch (\Exception $e) {
                throw new HttpResponseException(response()->json([
                    "errors" => [
                        "message" => "Format tanggal tidak sesuai!",
                        "permitted_dates" => [
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

        // Proceed with the import if all dates are valid
        foreach ($collection as $data) {
            // Process the data here
        }
    }
}
