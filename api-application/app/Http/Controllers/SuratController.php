<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuratRequest;
use App\Models\PenugasanModel;
use App\Models\PenugasanSuratModel;
use App\Models\SuratModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class SuratController extends Controller
{
    public function get(SuratRequest $request): JsonResponse
    {
        $data = $request->validated();

        $query = SuratModel::select(
            "surat.id",
            "surat.nomor",
            "surat.penanda_tangan",
            "surat.tanggal_surat",
            "admin.nama_lengkap as pembuat_surat",
            "surat.kalimat_pembuka",
            "surat.isi_surat",
            "surat.kalimat_penutup",
            "surat.created_at",
            "surat.jabatan_penanda_tangan"
        )->join("admin", "admin.id", "surat.admin_id")
            ->where("surat.is_draft", false);

        if (!empty($data["search"])) {
            $query->where(function ($query) use ($data) {
                $query->where("surat.penanda_tangan", "like", "%{$data["search"]}%")
                    ->orWhere("surat.nomor", "like", "%{$data["search"]}%")
                    ->orWhere("admin.nama_lengkap", "like", "%{$data["search"]}%")
                    ->orWhere("surat.isi_surat", "like", "%{$data["search"]}%");
            });
        }

        $surat = $query->paginate($data["length"]);

        $tmp_data = $surat->getCollection()->map(function ($item) {
            $item["ditugaskan"] = PenugasanModel::select(
                "penugasan.nama",
                "penugasan.jabatan",
                "penugasan.alamat",
            )->join("penugasan_surat", "penugasan_surat.penugasan_id", "penugasan.id")
                ->where('penugasan_surat.surat_id', $item->id)
                ->get();

            /**
             * String blob pdf
             *
             */
            $pdf = Pdf::loadView("SuratPDF", $item->toArray());

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

            return [
                "penanda_tangan" => $item->penanda_tangan,
                "nomor" => $item->nomor,
                "pembuat_surat" => $item->pembuat_surat,
                "isi_surat" => $item->isi_surat,
                "tanggal_surat" => $item->tanggal_surat,
                "created_at" => Carbon::parse($item->created_at)->format('d-m-Y H:i:s'),
                "file" => $pdfBase64
            ];
        });

        $surat = $surat->setCollection($tmp_data);

        /**
         * Mengembalikan response
         *
         */
        return response()->json($surat)->setStatusCode(200);
    }

    public function preview(Request $request): JsonResponse
    {
        $data = $request->validate([
            "nomor" => "required|string",
            "penanda_tangan" => "required|string",
            "tanggal_surat" => "required|date",
            "kalimat_pembuka" => "required|string",
            "isi_surat" => "required|string",
            "kalimat_penutup" => "required|string",
            "ditugaskan" => "required|array",
            "jabatan_penanda_tangan" => "required|string"
        ]);

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
            "nomor" => $surat->nomor,
            "penanda_tangan" => $surat->penanda_tangan,
            "tanggal_surat" => $surat->tanggal_surat,
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
            "jabatan_penanda_tangan" => $data["jabatan_penanda_tangan"],
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
