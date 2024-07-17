<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmissionRequest;
use App\Models\SubmissionModel;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    public function get(SubmissionRequest $request): JsonResponse
    {
        $data = $request->validated();

        return response()->json()->setStatusCode(200);
    }
    public function post(SubmissionRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (!empty($data['file'])) {
            $base64Parts = explode(",", $data['file']);
            $base64Zip = end($base64Parts);
            $decodedZip = base64_decode($base64Zip);

            $fileSize = strlen($decodedZip);
            $maxFileSize = 10 * 1024 * 1024;

            if ($fileSize > $maxFileSize) {
                return response()->json([
                    'errors' => [
                        'message' => "Ukuran file zip tidak boleh lebih dari 10 MB"
                    ]
                ])->setStatusCode(400);
            }

            $zipName = Auth::user()->id . Carbon::now()->format('Y-m-d') . '_' . time() . '.zip';
            $zipPath = 'files/upload/' . $zipName;

            file_put_contents(public_path($zipPath), $decodedZip);
            $data['file'] = '/' . $zipPath;
        }

        SubmissionModel::create($data);

        return response()->json([
            "success" => [
                "message" => "Sumbission berhasil dikirim!"
            ]
        ])->setStatusCode(201);
    }
}
