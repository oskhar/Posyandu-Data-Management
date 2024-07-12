<?php

namespace App\Http\Controllers;

use App\Http\Requests\DrafSuratRequest;
use App\Models\PenugasanModel;
use App\Models\PenugasanSuratModel;
use App\Models\SuratModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DrafSuratController extends Controller
{
    public function get(DrafSuratRequest $request): JsonResponse
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
        )->join("admin", "admin.id", "surat.admin_id")
            ->where("surat.is_draft", true);

        if (!empty($data["search"])) {
            $query->where(function ($query) use ($data) {
                $query->where("surat.penanda_tangan", "like", "%{$data["search"]}%")
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
                "id" => $item->id,
                "nomor" => $item->nomor,
                "penanda_tangan" => $item->penanda_tangan,
                "tanggal_surat" => $item->tanggal_surat,
                "isi_surat" => $item->isi_surat,
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
    public function post(DrafSuratRequest $request): JsonResponse
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
            "is_draft" => true,
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

        return response()->json([
            "success" => [
                "message" => "Berhasil dimasukan dalam draf"
            ]
        ])->setStatusCode(201);
    }

    public function put(DrafSuratRequest $request, $id): JsonResponse
    {
        /**
         * Memeriksa apakah request sesuai
         * dengan ketentuan berlaku
         *
         */
        $data = $request->validated();

        /**
         * Memperbarui data surat
         * di database
         *
         */
        $surat = SuratModel::findOrFail($id);
        $surat->update([
            "penanda_tangan" => $data["penanda_tangan"],
            "tanggal_surat" => $data["tanggal_surat"],
            "nomor" => $data["nomor"],
            "kalimat_pembuka" => $data["kalimat_pembuka"],
            "isi_surat" => $data["isi_surat"],
            "kalimat_penutup" => $data["kalimat_penutup"],
        ]);

        /**
         * Memperbarui data petugas
         * di database
         *
         */
        $existingPenugasanIds = PenugasanSuratModel::where('surat_id', $surat->id)->pluck('penugasan_id')->toArray();

        // Array untuk menyimpan ID penugasan yang diterima dari request
        $newPenugasanIds = [];

        foreach ($data["ditugaskan"] as $ditugaskan) {
            if (isset($ditugaskan["id"]) && in_array($ditugaskan["id"], $existingPenugasanIds)) {
                $penugasan = PenugasanModel::findOrFail($ditugaskan["id"]);
                $penugasan->update([
                    "nama" => $ditugaskan["nama"],
                    "jabatan" => $ditugaskan["jabatan"],
                    "alamat" => $ditugaskan["alamat"],
                ]);
                $newPenugasanIds[] = $penugasan->id;
            } else {
                $penugasan = PenugasanModel::create([
                    "nama" => $ditugaskan["nama"],
                    "jabatan" => $ditugaskan["jabatan"],
                    "alamat" => $ditugaskan["alamat"],
                ]);

                PenugasanSuratModel::create([
                    "surat_id" => $surat->id,
                    "penugasan_id" => $penugasan->id
                ]);
                $newPenugasanIds[] = $penugasan->id;
            }
        }

        /**
         * Menghapus penugasan yang tidak ada di data baru
         *
         */
        $penugasanToDelete = array_diff($existingPenugasanIds, $newPenugasanIds);

        foreach ($penugasanToDelete as $penugasanId) {
            PenugasanSuratModel::where('surat_id', $surat->id)->where('penugasan_id', $penugasanId)->delete();
            PenugasanModel::findOrFail($penugasanId)->delete();
        }

        return response()->json([
            "success" => [
                "message" => "Draf berhasil diperbarui"
            ]
        ])->setStatusCode(200);
    }
    public function delete($id): JsonResponse
    {
        /**
         * Mengambil surat berdasarkan ID dan memeriksa apakah surat tersebut adalah draft
         * dan memeriksa apakah ada
         *
         */
        $surat = SuratModel::where('id', $id)->where('is_draft', true)->firstOrFail();

        /**
         * Menghapus semua data penugasan yang terkait dengan surat ini
         *
         */
        $penugasanIds = PenugasanSuratModel::where('surat_id', $surat->id)->pluck('penugasan_id')->toArray();

        foreach ($penugasanIds as $penugasanId) {
            PenugasanSuratModel::where('surat_id', $surat->id)->where('penugasan_id', $penugasanId)->delete();
            PenugasanModel::findOrFail($penugasanId)->delete();
        }

        /**
         * Menghapus surat
         *
         */
        $surat->delete();

        return response()->json([
            "success" => [
                "message" => "Draf surat dan penugasan terkait berhasil dihapus"
            ]
        ])->setStatusCode(200);
    }

    public function draftToSurat($id): JsonResponse
    {
        // Coba untuk menemukan surat dengan ID yang diberikan
        SuratModel::where("id", $id)->update([
            "is_draft" => false
        ]);

        return response()->json([
            "success" => [
                "message" => "Draf berhasil dicetak sebagai surat",
            ]
        ])->setStatusCode(200);
    }

}
