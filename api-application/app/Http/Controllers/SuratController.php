<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuratRequest;
use App\Models\PenugasanModel;
use App\Models\PenugasanSuratModel;
use App\Models\SuratModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Type\Integer;

class SuratController extends Controller
{
    public function get(): JsonResponse
    {
        /**
         * Mengembalikan response
         *
         */
        return response()->json(
            SuratModel::select(
                "surat.penanda_tangan",
                "admin.nama_lengkap as pembuat_surat",
                "surat.isi_surat",
                "surat.tanggal_surat",
                "surat.created_at",
            )->join("admin", "admin.id", "surat.admin_id")
                ->get()
        )->setStatusCode(200);
    }

    public function show($id): JsonResponse
    {
        /**
         * Query untuk mengambil data surat
         *
         * @var SuratModel
         */
        $surat = SuratModel::findOrFail($id);

        /**
         * Mendapatkan data untuk PDF
         *
         */
        $data = [
            "penanda_tangan" => $surat->penanda_tangan,
            "tanggal_surat" => $surat->tanggal_surat,
            "nomor" => $surat->nomor,
            "kalimat_pembuka" => $surat->kalimat_pembuka,
            "isi_surat" => $surat->isi_surat,
            "kalimat_penutup" => $surat->kalimat_penutup,
            'ditugaskan' => PenugasanModel::select(
                "penugasan.nama",
                "penugasan.jabatan",
                "penugasan.alamat",
            )->join("penugasan_surat", "penugasan_surat.penugasan_id", "penugasan.id")
                ->where('penugasan_surat.surat_id', $surat->id)
                ->get()
        ];

        /**
         * String blob pdf
         *
         */
        $pdf = Pdf::loadView("SuratPDF", $data);

        /**
         * Mendapatkan PDF string
         *
         */
        $pdfContent = $pdf->output();

        /**
         * Convert PDF content to base64
         *
         */
        $pdfBase64 = base64_encode($pdfContent);

        return response()->json(
            $pdfBase64
        )->setStatusCode(200);
    }

    public function post(SuratRequest $request): JsonResponse
    {
        /**
         * Memeriksa apakah request sesuai
         * dengan ketentuan berlaku
         *
         */
        $data = $request->validated();

        /**
         * Menambahkan data surat
         * ke database
         *
         */
        $surat = SuratModel::create([
            "admin_id" => Auth::user()->id,
            "penanda_tangan" => $data["penanda_tangan"],
            "tanggal_surat" => $data["tanggal_surat"],
            "nomor" => $data["nomor"],
            "kalimat_pembuka" => $data["kalimat_pembuka"],
            "isi_surat" => $data["isi_surat"],
            "kalimat_penutup" => $data["kalimat_penutup"],
        ]);

        /**
         * Menambahkan data petugas
         * ke database
         *
         */
        foreach ($data["ditugaskan"] as $ditugaskan) {
            $penugasan = PenugasanModel::create([
                "nama" => $ditugaskan["nama"],
                "jabatan" => $ditugaskan["jabatan"],
                "alamat" => $ditugaskan["alamat"],
            ]);

            PenugasanSuratModel::create([
                "surat_id" => $surat->id,
                "penugasan_id" => $penugasan->id
            ]);
        }

        /**
         * String blob pdf
         *
         */
        $pdf = Pdf::loadView("SuratPDF", $data);

        /**
         * Mendapatkan PDF string
         *
         */
        $pdfContent = $pdf->output();

        /**
         * Convert PDF content to base64
         *
         */
        $pdfBase64 = base64_encode($pdfContent);

        /**
         * Mengembalikan response
         *
         */
        return response()->json([
            "success" => [
                "message" => "Surat berhasil ditambahkan",
                "file" => $pdfBase64
            ]
        ])->setStatusCode(201);
    }
}
