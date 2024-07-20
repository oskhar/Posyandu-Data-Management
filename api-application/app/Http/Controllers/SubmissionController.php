<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmissionRequest;
use App\Models\PenilaianModel;
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

        $query = SubmissionModel::select(
            "submission.id",
            "submission.tantangan_id",
            "submission.file",
            "submission.link",
            "penilaian.feedback",
            "penilaian.peringkat",
            "submission.status",
            "user.nama as nama_user",
        )
            ->leftJoin("penilaian", "penilaian.submission_id", "submission.id")
            ->join("user", "user.id", "submission.user_id");

        if (!empty($data["search"])) {
            $query->where("user.nama", "like", "%{$data["search"]}%");
        }

        if (!empty($data["tantangan_id"])) {
            $query->where("submission.tantangan_id", $data["tantangan_id"]);
        }

        $submission = $query->paginate($data["length"]);

        return response()->json($submission)->setStatusCode(200);
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

        $data["user_id"] = Auth::user()->id;

        SubmissionModel::create($data);

        return response()->json([
            "success" => [
                "message" => "Sumbission berhasil dikirim!"
            ]
        ])->setStatusCode(201);
    }

    public function put(SubmissionRequest $request, $id): JsonResponse
    {
        $data = $request->validated();

        PenilaianModel::where("submission_id", $id)
            ->update($data);

        return response()->json([
            "success" => [
                "message" => "Submission berhasil dinilai!"
            ]
        ])->setStatusCode(200);
    }

    public function delete($id): JsonResponse
    {

        SubmissionModel::findOrFail($id)->delete();

        return response()->json([
            "success" => [
                "message" => "Submission berhasil ditarik kembali!"
            ]
        ])->setStatusCode(200);
    }
}
