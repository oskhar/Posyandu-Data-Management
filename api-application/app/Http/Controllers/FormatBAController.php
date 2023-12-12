<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormatARequest;
use App\Http\Requests\FormatBARequest;
use App\Models\BayiModel;
use App\Models\FormatBModel;
use App\Models\OrangTuaModel;
use App\Models\PosyanduModel;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FormatBAController extends Controller
{
    protected $judulFormat = 'Regrister bayi (0 - 5 bulan) dalam wilayah kerja posyandu Januari - Desember';
    public function get(FormatBARequest $request): JsonResponse
    {
        /**
         * Melakukan validasi data request
         * 
         */
        $data = $request->validated();

        /**
         * Membuat query utama
         * 
         */
        $query = FormatBModel::select(
            'format_a.id as id_format_a',
            'bayi.nama as nama_bayi',
            'bayi.jenis_kelamin',
            'bayi.tanggal_lahir',
            'bayi.berat_lahir',
            'orang_tua.nama_ibu',
            'orang_tua.nama_ayah',
            'orang_tua.rt_rw',
            'orang_tua.memiliki_kms',
            'orang_tua.memiliki_kia',
            'format_a.keterangan',
            'format_a.created_at as tanggal'
        )
            ->join('bayi', 'bayi.id', 'format_a.id_bayi')
            ->join('orang_tua', 'orang_tua.id', 'bayi.id_orang_tua')
            ->orderBy('bayi.tanggal_lahir', 'ASC');

        /**
         * Memasukan data penimbangan
         */

        /**
         * Mengembalikan response sesuai request
         * 
         */
        return response()->json([
        ])->setStatusCode(200);
    }
    public function post(FormatBARequest $request): JsonResponse
    {

        /**
         * Memeriksa apakah request sesuai
         * dengan ketentuan berlaku
         * 
         */
        $data = $request->validated();

        if (empty($data['id_bayi'])) {

            /**
             * Memeriksa apakah data yang
             * dibutuhkan sudah tersedia
             * 
             */
            if (empty($data['nama_ibu']) || empty($data['nama_bayi'])) {
                throw new HttpResponseException(response()->json([
                    'errors' => [
                        'message' => 'Data nama_ibu atau nama_bayi tidak boleh kosong'
                    ]
                ])->setStatusCode(400));
            }

            /**
             * Melakukan penambahan data orang_tua
             * 
             */
            $orangTua = OrangTuaModel::create([
                'nama_ayah' => $data['nama_ayah'],
                'nama_ibu' => $data['nama_ibu'],
                'tanggal_meninggal_ibu' => $data['tanggal_meninggal_ibu'],
            ]);

            /**
             * Melakukan penambahan data bayi
             * 
             */
            $bayi = BayiModel::create([
                'id_orang_tua' => $orangTua->id,
                'nama' => $data['nama_bayi'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'tanggal_meninggal' => $data['tanggal_meninggal_bayi'],
            ]);
        }

        /**
         * Melakukan penambahan data format_a
         * 
         */
        FormatBModel::create([
            'id_bayi' => $data['id_bayi'] ?? $bayi->id,
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
    public function put(FormatBARequest $request): JsonResponse
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
        $formatA = FormatBModel::select(
            'format_a.id_bayi',
            'orang_tua.nama_ayah',
            'orang_tua.nama_ibu',
            'bayi.nama as nama_bayi',
            'bayi.jenis_kelamin',
            'bayi.tanggal_lahir',
            'bayi.tanggal_meninggal as tanggal_meninggal_bayi',
            'orang_tua.tanggal_meninggal_ibu',
            'format_a.keterangan'
        )
            ->join('bayi', 'bayi.id', 'format_a.id_bayi')
            ->join('orang_tua', 'orang_tua.id', 'bayi.id_orang_tua')
            ->where('format_a.id', $data['id_format_a'])
            ->first();

        /**
         * Melakukan pengubahan data format_a
         * 
         */
        FormatBModel::where('id', $data['id_format_a'])->update([
            'id_bayi' => $formatA->id_bayi,
            'keterangan' => $data['keterangan'] ?? $formatA->keterangan,
        ]);

        /**
         * Melakukan pengubahan data bayi
         * 
         */
        $bayi = BayiModel::where('id', $formatA->id_bayi);
        $bayi->update([
            'nama' => $data['nama_bayi'] ?? $formatA->nama_bayi,
            'jenis_kelamin' => $data['jenis_kelamin'] ?? $formatA->jenis_kelamin,
            'tanggal_lahir' => $data['tanggal_lahir'] ?? $formatA->tanggal_lahir,
            'tanggal_meninggal' => $data['tanggal_meninggal_bayi'] ?? $formatA->tanggal_meninggal_bayi,
        ]);
        $bayi = $bayi->select('id_orang_tua')->first();

        /**
         * Melakukan pengubahan data orang_tua
         * 
         */
        OrangTuaModel::where('id', $bayi->id_orang_tua)->update([
            'nama_ayah' => $data['nama_ayah'] ?? $formatA->nama_ayah,
            'nama_ibu' => $data['nama_ibu'] ?? $formatA->nama_ibu,
            'tanggal_meninggal_ibu' => $data['tanggal_meninggal_ibu'] ?? $formatA->tanggal_meninggal_ibu,
        ]);

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
    public function delete(FormatBARequest $request): JsonResponse
    {
        /**
         * Memeriksa apakah request
         * yang diberikan sesuai
         * 
         */
        $data = $request->validated();

        /**
         * Mendapatkan data yang dituju menggunakan
         * request id dan mlakukan penghapusan data
         * 
         */
        FormatBModel::where('id', $data['id_format_a'])
            ->delete();

        /**
         * Mengembalikan response setelah
         * melakukan delete data
         * 
         */
        return response()->json([
            'success' => [
                'message' => "Data edukasi berhasil dihapus"
            ]
        ])->setStatusCode(200);
    }
}
