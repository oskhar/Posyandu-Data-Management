<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormatCRequest;
use App\Models\FormatCModel;
use App\Models\OrangTuaModel;
use App\Models\PosyanduModel;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FormatCController extends Controller
{
    public function get(FormatCRequest $request): JsonResponse
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
        $query = FormatCModel::select(
            'orang_tua.nama_ibu',
            'format_c.umur',
            'orang_tua.nama_ayah',
            'format_c.tahapan_ks',
        )->join('orang_tua', 'orang_tua.id', 'format_c.id_orang_tua')
            ->orderByDesc('format_c.created_at');

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
        $formatC = $query->get();

        /**
         * Mengambil data posyandu
         * 
         */
        $posyandu = PosyanduModel::select(
            'nama_posyandu',
            'kota'
        )->first();

        /**
         * Memeberikan data yang diminta
         * melalui response
         * 
         */
        return response()->json([
            'jumlah_data' => $count,
            'format_c' => $formatC,
            'judul_format' => 'Register WUS dan PUS dalam wilayah kerja posyandu',
            'nama_posyandu' => $posyandu->nama_posyandu,
            'kota' => $posyandu->kota,
        ])->setStatusCode(200);
    }
    public function post(FormatCRequest $request): JsonResponse
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
        FormatCModel::create([
            'id_orang_tua' => $data['id_orang_tua'],
            'umur' => $data['umur'],
            'tahapan_ks' => $data['tahapan_ks'],
            'kelompok_dasawisma' => $data['kelompok_dasawisma'],
            'lila' => $data['lila'],
            'jumlah_anak_hidup' => $data['jumlah_anak_hidup'],
            'jumlah_anak_meninggal' => $data['jumlah_anak_meninggal'],
            'imunisasi' => empty($data['imunisasi']) ? '' : implode(',', $data['imunisasi']),
            'jenis_kontrasepsi' => $data['jenis_kontrasepsi'],
            'tanggal_penggantian' => $data['tanggal_penggantian'],
            'penggantian_jenis_kontrasepsi' => $data['penggantian_jenis_kontrasepsi'],
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
    public function put(FormatCRequest $request): JsonResponse
    {
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
    public function delete(FormatCRequest $request): JsonResponse
    {
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
