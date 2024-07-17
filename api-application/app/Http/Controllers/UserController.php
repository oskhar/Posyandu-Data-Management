<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\UserModel;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function get(UserRequest $request): JsonResponse
    {
        $data = $request->validated();

        $query = UserModel::select(
            "id",
            "nama",
            "email",
            "password",
            "whatsapp",
            "foto_profile",
        );

        if (!empty($data["search"])) {
            $query->where(function ($query) use ($data) {
                $query->where("judul", "like", "%{$data["search"]}%")
                    ->orWhere("deskripsi", "like", "%{$data["search"]}%");
            });
        }

        $user = $query->paginate($data["length"]);

        return response()->json($user)->setStatusCode(200);
    }
    public function delete($id): JsonResponse
    {
        UserModel::findOrFail($id)
            ->delete();

        return response()->json([
            "success" => [
                "message" => "User berhasil diperbarui"
            ]
        ])->setStatusCode(200);
    }
}
