<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormatARequest;
use App\Models\BayiModel;
use App\Models\FormatAModel;
use App\Models\OrangTuaModel;
use App\Models\PosyanduModel;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FormatAController extends Controller
{
    protected $judulFormat = 'Catatan ibu hamil, kelahiran, kematian bayi dan kematian ibu hamil, melahirkan / nifas januari - desember tahun';
    public function get(FormatARequest $request): JsonResponse
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
        $query = FormatAModel::select(
            'format_a.id as id_format_a',
            'orang_tua.nama_ayah',
            'orang_tua.nama_ibu',
            'bayi.nama as nama_bayi',
            'bayi.jenis_kelamin',
            'bayi.tanggal_lahir',
            'bayi.tanggal_meninggal as tanggal_meninggal_bayi',
            'orang_tua.tanggal_meninggal_ibu',
            'format_a.keterangan',
            'format_a.created_at as tanggal'
        )
            ->join('bayi', 'bayi.id', 'format_a.id_bayi')
            ->join('orang_tua', 'orang_tua.id', 'bayi.id_orang_tua')
            ->orderByDesc('format_a.created_at');

        /**
         * Mendapatkan data jumlah kematian
         * dan jumlah kelahiran bayi
         * 
         */
        $jumlahKematian = $query->whereNotNull('bayi.tanggal_meninggal')->count();

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
            $query = $query->where('nama_bayi', 'LIKE', '%' . $data['search'] . '%');

        }

        /**
         * Mengambil banyaknya data yang diambil
         * 
         */
        $count = $query->count();
        $jumlahKelahiran = $count - $jumlahKematian;
        $jumlahKematian += $query->whereNotNull('orang_tua.tanggal_meninggal_ibu')->count();

        /**
         * Memeriksa apakah data ingin difilter
         * 
         */
        if (isset($data['start']) && isset($data['length'])) {

            /**
             * Mengambil data gambar dari
             * query yang sudah difilter
             * 
             */
            $formatA = $query
                ->offset(($data['start'] - 1) * $data['length'])
                ->limit($data['length']);

        }

        /**
         * Mengambil data dari query dan
         * akan dijadikan response
         * 
         */
        $formatA = $query->get();

        /**
         * Memeriksa apakah id_format_a ada
         * 
         */
        if (!empty($data['id_format_a'])) {

            /**
             * Mengambil query data sesuai id
             * 
             */
            $query = $query->where('id', $data['id_format_a']);

            /**
             * Mengambil data dari query dan
             * akan dijadikan response
             * 
             */
            $count = $query->count();
            $formatA = $query->first();

        }

        /**
         * Mengambil data posyandu
         * 
         */
        $posyandu = PosyanduModel::select(
            'nama_posyandu',
            'kota'
        )->first();

        /**
         * Mengembalikan response sesuai request
         * 
         */
        return response()->json([
            'nama_posyandu' => $posyandu->nama_posyandu,
            'kota' => $posyandu->kota,
            'judul_format' => $this->judulFormat,
            'jumlah_kelahiran' => $jumlahKelahiran,
            'jumlah_kematian' => $jumlahKematian,
            'jumlah_data' => $count,
            'format_a' => $formatA,
        ])->setStatusCode(200);
    }
    public function post(FormatARequest $request): JsonResponse
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
        FormatAModel::create([
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
    public function put(FormatARequest $request): JsonResponse
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
        $formatA = FormatAModel::select(
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
            ->find($data['id_format_a'])
            ->first();

        /**
         * Melakukan pengubahan data format_a
         * 
         */
        FormatAModel::find($data['id_format_a'])->update([
            'id_bayi' => $formatA->id_bayi,
            'keterangan' => $data['keterangan'] ?? $formatA->keterangan,
        ]);

        /**
         * Melakukan pengubahan data bayi
         * 
         */
        $bayi = BayiModel::find($formatA->id_bayi)->update([
            'nama' => $data['nama_bayi'] ?? $formatA->nama_bayi,
            'jenis_kelamin' => $data['jenis_kelamin'] ?? $formatA->jenis_kelamin,
            'tanggal_lahir' => $data['tanggal_lahir'] ?? $formatA->tanggal_lahir,
            'tanggal_meninggal' => $data['tanggal_meninggal_bayi'] ?? $formatA->tanggal_meninggal_bayi,
        ]);

        /**
         * Melakukan pengubahan data orang_tua
         * 
         */
        OrangTuaModel::find($bayi->id_orang_tua)->update([
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
    public function delete(FormatARequest $request): JsonResponse
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
        FormatAModel::find($data['id_format_a'])
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
