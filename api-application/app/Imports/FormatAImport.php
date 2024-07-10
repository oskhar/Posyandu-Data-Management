<?php

namespace App\Imports;
use Illuminate\Http\JsonResponse;

class FormatAImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return JsonResponse|null
     */
    public function model(): JsonResponse
    {


        return response()->json([
            "success" => [
                "message" => "Data berhasil diimport"
            ]
        ])->setStatusCode(201);
    }
}
