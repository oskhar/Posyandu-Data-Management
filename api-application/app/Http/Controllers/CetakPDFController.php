<?php

namespace App\Http\Controllers;

use App\Models\SuratModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Ramsey\Uuid\Type\Integer;


class CetakPDFController extends Controller
{
    public static function surat(Integer $id)
    {
        /**
         * Query untuk mengambil data surat
         *
         * @var SuratModel
         */
        $surat = SuratModel::with('penugasan')->findOrFailr($id);

        /**
         * Menyiapkan data yang akan
         * ditampilkan pdf
         *
         */
        $data = [
            "penanda_tangan" => $surat->penanda_tangan,
            "tanggal_surat" => $surat->tanggal_surat,
            "nomor" => $surat->nomor,
            "kalimat_pembuka" => $surat->kalimat_pembuka,
            "isi_surat" => $surat->isi_surat,
            "kalimat_penutup" => $surat->kalimat_penutup,
            'ditugaskan' => $surat->penugasan->map(function ($penugasan) {
                return [
                    'nama' => $penugasan->nama,
                    'jabatan' => $penugasan->jabatan,
                    'alamat' => $penugasan->alamat,
                ];
            })->toArray()
        ];


        /**
         * Mempersiapkan class pdf
         *
         */
        $pdf = PDF::loadView("SuratPDF", $data);
        return $pdf->download("Surat Penugasan.pdf");
    }
}
