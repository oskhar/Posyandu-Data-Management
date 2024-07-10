<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuratRequest;
use App\Models\PenugasanModel;
use App\Models\SuratModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Type\Integer;

class SuratController extends Controller
{
    public function index(): JsonResponse
    {


        /**
         * Mengembalikan response
         *
         */
        return response()->json()->setStatusCode(200);
    }

    public function show(Integer $id): JsonResponse
    {
        /**
         * Mengembalikan response
         *
         */
        return response()->json([

        ])->setStatusCode(200);
    }

    public function create(SuratRequest $request): JsonResponse
    {
        /**
         * Memeriksa apakah request sesuai
         * dengan ketentuan berlaku
         *
         */
        $data = $request->validated();

        SuratModel::create([
            "admin_id" => Auth::user()->id,
            "penanda_tangan" => $data["penanda_tangan"],
            "tanggal_surat" => $data["tanggal_surat"],
            "nomor_telepon" => $data["nomor_telepon"],
            "kalimat_pembuka" => $data["kalimat_pembuka"],
            "isi_surat" => $data["isi_surat"],
            "kalimat_penutup" => $data["kalimat_penutup"],
        ]);

        foreach ($data["ditugaskan"] as $ditugaskan) {
            PenugasanModel::create([
                "nama" => $ditugaskan["nama"],
                "jabatan" => $ditugaskan["jabatan"],
                "alamat" => $ditugaskan["alamat"],
            ]);
        }

        /**
         * Mengembalikan response
         *
         */
        return response()->json([
            "success" => [
                "message" => "Surat berhasil ditambahkan",
                "file" => ""
            ]
        ])->setStatusCode(201);
    }
}
