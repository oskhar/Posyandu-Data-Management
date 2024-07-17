<?php

namespace App\Http\Controllers;

use App\Http\Requests\TantanganRequest;
use App\Models\TantanganModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TantanganController extends Controller
{
    public function get(TantanganRequest $request): JsonResponse
    {
        $data = $request->validated();

        $query = TantanganModel::select(
            "id",
            "judul",
            "gambar",
            "deskripsi",
            "tanggal_mulai",
            "tanggal_selesai",
            "created_at"
        );

        if (!empty($data["search"])) {
            $query->where(function ($query) use ($data) {
                $query->where("judul", "like", "%{$data["search"]}%")
                    ->orWhere("deskripsi", "like", "%{$data["search"]}%");
            });
        }

        $tantangan = $query->paginate($data["length"]);

        return response()->json($tantangan)->setStatusCode(200);
    }

    public function post(TantanganRequest $request): JsonResponse
    {
        $data = $request->validated();

        TantanganModel::create($data);

        return response()->json([
            "success" => [
                "message" => "Tantangan berhasil ditambahkan"
            ]
        ])->setStatusCode(201);
    }
    public function put(TantanganRequest $request, $id): JsonResponse
    {
        $data = $request->validated();

        TantanganModel::findOrFail($id)
            ->update($data);

        return response()->json([
            "success" => [
                "message" => "Tantangan berhasil diperbarui"
            ]
        ])->setStatusCode(200);
    }
    public function delete($id): JsonResponse
    {
        TantanganModel::findOrFail($id)
            ->delete();
        return response()->json([
            "success" => [
                "message" => "Tantangan telah dihapus!"
            ]
        ])->setStatusCode(200);
    }

    public function user(TantanganRequest $request): JsonResponse
    {
        $data = $request->validated();

        $query = TantanganModel::select(
            "tantangan.id",
            "tantangan.judul",
            "tantangan.gambar",
            "tantangan.deskripsi",
            "tantangan.tanggal_mulai",
            "tantangan.tanggal_selesai",
            "tantangan.created_at"
        )->join("submission", "tantangan.id", "submission.tantangan_id")
            ->where("submission.user_id", Auth::user()->id);

        if (!empty($data["search"])) {
            $query->where(function ($query) use ($data) {
                $query->where("judul", "like", "%{$data["search"]}%")
                    ->orWhere("deskripsi", "like", "%{$data["search"]}%");
            });
        }

        $tantangan = $query->paginate($data["length"]);

        return response()->json($tantangan)->setStatusCode(200);
    }
}
