<?php

namespace App\Http\Controllers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use App\Imports\FormatAImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function importFormatAExcel(Request $request): JsonResponse
    {
        // Validate the request to ensure 'file' is present
        $request->validate([
            'file' => 'required|file',
        ]);

        // Import the Excel file
        try {
            Excel::import(new FormatAImport, $request->file("file"));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = [
                    'row' => $failure->row(),
                    'attribute' => $failure->attribute(),
                    'errors' => $failure->errors(),
                ];
            }

            return response()->json([
                'errors' => $errorMessages,
                'file' => $request->file('file')->getClientOriginalName()
            ])->setStatusCode(422);
        } catch (HttpResponseException $e) {
            // Catch HttpResponseException to extract the response data
            return response()->json($e->getResponse()->getData())->setStatusCode(422);
        } catch (\Exception $e) {
            return response()->json([
                'errors' => [
                    'message' => 'Import gagal: ' . $e->getMessage(),
                    'file' => $request->file('file')->getClientOriginalName()
                ]
            ])->setStatusCode(422);
        }

        return response()->json([
            "success" => [
                'message' => 'Berhasil mengimport data'
            ]
        ])->setStatusCode(201);
    }
}
