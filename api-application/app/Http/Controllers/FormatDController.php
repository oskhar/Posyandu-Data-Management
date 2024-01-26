<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormatDRequest;
use App\Models\FormatDModel;
use App\Models\OrangTuaModel;
use App\Models\PosyanduModel;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FormatDController extends Controller
{
    public function get(FormatDRequest $request): JsonResponse
    {

        /**
         * Memeriksa apakah request sesuai
         * dengan ketentuan berlaku
         * 
         */
        $data = $request->validated();

        /**
         * Membuat query utama
         * 
         */
        $query = FormatDModel::select(
            'orang_tua.nama_ibu',
            'orang_tua.nama_ayah',
            'orang_tua.nik_ibu',
            'orang_tua.nik_ayah',
            'orang_tua.tanggal_meninggal_ibu',
            'orang_tua.no_telp',
            'orang_tua.rt_rw',
            'orang_tua.tempat_tinggal',
            'format_d.id as id_format_d',
            'format_d.umur',
            'format_d.kelompok_dasawisma',
            'format_d.tanggal_pendaftaran',
            'format_d.umur_kehamilan',
            'format_d.hamil_ke',
            'format_d.lila',
            'format_d.pmt_pemulihan',
            'format_d.penimbangan',
            'format_d.pil_tambah_darah',
            'format_d.imunisasi',
            'format_d.vit_a',
            'format_d.keterangan',
        )->join('orang_tua', 'orang_tua.id', 'format_d.id_orang_tua')
            ->orderByDesc('format_d.created_at');

        /**
         * Melakukan filtering atau penyaringan
         * data pada kondisi tertentu
         * 
         */
        if (!empty($data['search'])) {

            /**
             * Memfilter data sesuai request search
             * 
             */
            $query = $query->where('orang_tua.nama_ayah', 'LIKE', '%' . $data['search'] . '%')
                ->orWhere('orang_tua.nama_ibu', 'LIKE', '%' . $data['search'] . '%');

        }

        /**
         * Mengambil banyaknya data yang diambil
         * 
         */
        $count = $query->count();

        /**
         * Memeriksa apakah data ingin difilter
         * 
         */
        if (isset($data['start']) && isset($data['length'])) {
            $query = $query->offset(($data['start'] - 1) * $data['length'])
                ->limit($data['length']);
        }

        /**
         * Mendapatkan data format c
         * 
         */
        $formatD = $query->get();

        /**
         * Mengambil data posyandu
         * 
         */
        $posyandu = PosyanduModel::select(
            'nama_posyandu',
            'kota'
        )->first();

        /**
         * Mengubah data array dari imunisasi
         * 
         */
        $formatD = $formatD->map(function ($item) {
            $item->imunisasi = explode(',', $item->imunisasi);
            $item->penimbangan = explode(',', $item->penimbangan);
            $item->pil_tambah_darah = explode(',', $item->pil_tambah_darah);
            return $item;
        });

        /**
         * Memeberikan data yang diminta
         * melalui response
         * 
         */
        return response()->json([
            'jumlah_data' => $count,
            'format_d' => $formatD,
            'judul_format' => 'Register Ibu hamil dan nifas di wilayah kerja posyandu',
            'nama_posyandu' => $posyandu->nama_posyandu,
            'kota' => $posyandu->kota,
        ])->setStatusCode(200);
    }
    public function post(FormatDRequest $request): JsonResponse
    {

        /**
         * Memeriksa apakah request sesuai
         * dengan ketentuan berlaku
         * 
         */
        $data = $request->validated();

        /**
         * Memeriksa apakah data yang
         * dibutuhkan sudah tersedia
         * 
         */
        if (empty($data['nama_ibu']) && empty($data['id_orang_tua'])) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'Data nama ibu tidak boleh kosong',
                    'test' => $data
                ]
            ])->setStatusCode(400));
        }

        if (empty($data['id_orang_tua'])) {

            /**
             * Melakukan penambahan data orang_tua
             * 
             */
            $orangTua = OrangTuaModel::create([
                'nama_ayah' => $data['nama_ayah'],
                'nik_ayah' => $data['nik_ayah'],
                'nama_ibu' => $data['nama_ibu'],
                'nik_ibu' => $data['nik_ibu'],
                'tanggal_meninggal_ibu' => $data['tanggal_meninggal_ibu'],
                'no_telp' => $data['no_telp'],
                'rt_rw' => $data['rt_rw'],
                'tempat_tinggal' => $data['tempat_tinggal'],
            ]);

            /**
             * Inisiasi id data orang tua
             * 
             */
            $data['id_orang_tua'] = $orangTua->id;

        }

        /**
         * Menambahkan data format c
         * 
         */
        FormatDModel::create([
            'id_orang_tua' => $data['id_orang_tua'],
            'umur' => $data['umur'],
            'kelompok_dasawisma' => $data['kelompok_dasawisma'],
            'tanggal_pendaftaran' => $data['tanggal_pendaftaran'],
            'umur_kehamilan' => $data['umur_kehamilan'],
            'hamil_ke' => $data['hamil_ke'],
            'lila' => $data['lila'],
            'pmt_pemulihan' => $data['pmt_pemulihan'],
            'vit_a' => $data['vit_a'],
            'pil_tambah_darah' => empty($data['pil_tambah_darah']) ? '' : implode(',', $data['pil_tambah_darah']),
            'penimbangan' => empty($data['penimbangan']) ? '' : implode(',', $data['penimbangan']),
            'imunisasi' => empty($data['imunisasi']) ? '' : implode(',', $data['imunisasi']),
            'keterangan' => $data['keterangan'],
        ]);

        /**
         * Mengembalikan response setelah
         * melakukan penambahan data
         * 
         */
        return response()->json([
            'success' => [
                'message' => "Data berhasil ditambahkan"
            ]
        ])->setStatusCode(201);
    }

    public function put(FormatDRequest $request): JsonResponse
    {

        /**
         * Memeriksa apakah request sesuai
         * dengan ketentuan berlaku
         * 
         */
        $data = $request->validated();

        /**
         * Membuat query utama
         * 
         */
        $formatD = FormatDModel::select(
            'orang_tua.id as id_orang_tua',
            'orang_tua.nama_ibu',
            'orang_tua.nama_ayah',
            'orang_tua.nik_ibu',
            'orang_tua.nik_ayah',
            'orang_tua.tanggal_meninggal_ibu',
            'orang_tua.no_telp',
            'orang_tua.rt_rw',
            'orang_tua.tempat_tinggal',
            'format_d.umur',
            'format_d.kelompok_dasawisma',
            'format_d.tanggal_pendaftaran',
            'format_d.umur_kehamilan',
            'format_d.hamil_ke',
            'format_d.lila',
            'format_d.pmt_pemulihan',
            'format_d.penimbangan',
            'format_d.pil_tambah_darah',
            'format_d.imunisasi',
            'format_d.vit_a',
            'format_d.keterangan',
        )
            ->join('orang_tua', 'orang_tua.id', 'format_d.id_orang_tua')
            ->where('format_d.id', $data['id_format_d'])
            ->first();

        /**
         * Melakukan pengubahan data bayi
         * 
         */
        $wusPus = FormatDModel::where('id', $data['id_format_d']);
        $wusPus->update([
            'id_orang_tua' => $data['ganti_id_ortu'] ?? $formatD->id_orang_tua,
            'umur' => $data['umur'] ?? $formatD->umur,
            'kelompok_dasawisma' => $data['kelompok_dasawisma'] ?? $formatD->kelompok_dasawisma,
            'tanggal_pendaftaran' => $data['tanggal_pendaftaran'] ?? $formatD->tanggal_pendaftaran,
            'umur_kehamilan' => $data['umur_kehamilan'] ?? $formatD->umur_kehamilan,
            'hamil_ke' => $data['hamil_ke'] ?? $formatD->hamil_ke,
            'lila' => $data['lila'] ?? $formatD->lila,
            'pmt_pemulihan' => $data['pmt_pemulihan'] ?? $formatD->pmt_pemulihan,
            'pil_tambah_darah' => $data['pil_tambah_darah'] ? implode(',', $data['pil_tambah_darah']) : $formatD->pil_tambah_darah,
            'penimbangan' => $data['penimbangan'] ? implode(',', $data['penimbangan']) : $formatD->penimbangan,
            'imunisasi' => $data['imunisasi'] ? implode(',', $data['imunisasi']) : $formatD->imunisasi,
            'vit_a' => $data['vit_a'] ?? $formatD->vit_a,
            'keterangan' => $data['keterangan'] ?? $formatD->keterangan,
        ]);

        $wusPus = $wusPus->select('id_orang_tua')->first();

        if (empty($data['ganti_id_ortu'])) {

            /**
             * Melakukan pengubahan data orang_tua
             * 
             */
            OrangTuaModel::where('id', $wusPus->id_orang_tua)->update([
                'nama_ayah' => $data['nama_ayah'] ?? $formatD->nama_ayah,
                'nama_ibu' => $data['nama_ibu'] ?? $formatD->nama_ibu,
                'nik_ayah' => $data['nik_ayah'] ?? $formatD->nik_ayah,
                'nik_ibu' => $data['nik_ibu'] ?? $formatD->nik_ibu,
                'tanggal_meninggal_ibu' => $data['tanggal_meninggal_ibu'] ?? $formatD->tanggal_meninggal_ibu,
                'no_telp' => $data['no_telp'] ?? $formatD->no_telp,
                'tempat_tinggal' => $data['tempat_tinggal'] ?? $formatD->tempat_tinggal,
                'rt_rw' => $data['rt_rw'] ?? $formatD->rt_rw,
            ]);

        }

        /**
         * Mengembalikan response setelah
         * melakukan pengubahan data
         * 
         */
        return response()->json([
            'success' => [
                'message' => "Data berhasil diubah"
            ]
        ])->setStatusCode(201);
    }
    public function delete(FormatDRequest $request): JsonResponse
    {
        $data = $request->validated();

        /**
         * Mendapatkan id_orang tua
         * 
         */
        FormatDModel::where('format_d.id', $data['id_format_d'])
            ->delete();

        /**
         * Mengembalikan response setelah
         * melakukan penambahan data
         * 
         */
        return response()->json([
            'success' => [
                'message' => "Data berhasil ditambahkan"
            ]
        ])->setStatusCode(201);
    }
}
