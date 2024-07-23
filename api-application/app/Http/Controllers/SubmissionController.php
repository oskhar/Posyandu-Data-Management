<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmissionRequest;
use App\Models\PenilaianModel;
use App\Models\SubmissionModel;
use App\Models\UserModel;
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

        /**
         * Mengubah status submission
         *
         */
        $query->get()->each(function ($item) {
            if ($item->status == "Tersubmit") {
                $item->status = "Sedang Diperiksa";
                $item->save();
            }
        });

        $submission = $query->paginate($data["length"]);

        return response()->json($submission)->setStatusCode(200);
    }


    public function post(SubmissionRequest $request): JsonResponse
    {
        $data = $request->validated();

        /**
         * Memeriksa apakah user sudah submit
         * di tantangan ini sebelumnya
         *
         */
        $submissionExists = SubmissionModel::where('tantangan_id', $data['tantangan_id'])
            ->where('user_id', Auth::user()->id)
            ->exists();

        if ($submissionExists) {
            return response()->json([
                'errors' => [
                    'message' => 'Kamu sudah submit pada tantangan ini sebelumnya!'
                ]
            ])->setStatusCode(400);
        }

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

        $user = UserModel::findOrFail(Auth::user()->id);
        $user->update([
            "poin" => $user->poin + 50
        ]);

        return response()->json([
            "success" => [
                "message" => "Sumbission berhasil dikirim!"
            ]
        ])->setStatusCode(201);
    }

    public function put(SubmissionRequest $request, $id): JsonResponse
    {
        $data = $request->validated();

        $submission = SubmissionModel::findOrFail($id);
        $tantanganId = $submission->tantangan_id;

        $peringkatExists = PenilaianModel::join('submission', 'submission.id', '=', 'penilaian.submission_id')
            ->where('submission.tantangan_id', $tantanganId)
            ->where('penilaian.peringkat', $data['peringkat'])
            ->exists();

        if ($peringkatExists) {
            return response()->json([
                "errors" => [
                    "message" => "Peringkat {$data['peringkat']} sudah ditempati!"
                ]
            ], 422);
        }

        $penilaian = PenilaianModel::updateOrCreate(
            [
                'submission_id' => $id,
            ],
            [
                'submission_id' => $id,
                'admin_id' => Auth::user()->id,
                'feedback' => $data['feedback'],
                'peringkat' => $data['peringkat'],
                'poin' => $data['peringkat'] // Update poin column
            ]
        );

        $penambahanPoin = [0, 200, 150, 50][$data['peringkat']];

        $user = UserModel::findOrFail(Auth::user()->id);
        if ($penilaian->wasRecentlyCreated) {
            $user->update([
                "poin" => $user->poin + $penambahanPoin
            ]);
        } else {
            $poinLama = $penilaian->getOriginal('poin');
            if ($poinLama != $penambahanPoin) {
                $user->update([
                    "poin" => $user->poin - $poinLama + $penambahanPoin
                ]);
            }
        }

        if ($submission->status == "Sedang Diperiksa") {
            $submission->update([
                "status" => "Sudah Dinilai"
            ]);
        }

        return response()->json([
            'success' => [
                'message' => 'Submission successfully evaluated!'
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
