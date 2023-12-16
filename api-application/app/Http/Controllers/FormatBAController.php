<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormatBARequest;
use App\Models\BayiModel;
use App\Models\OrangTuaModel;
use App\Models\PenimbanganModel;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FormatBAController extends Controller
{
    protected $judulFormat = 'Regrister bayi (0 - 5 bulan) dalam wilayah kerja posyandu Januari - Desember';
    protected $namaBulan = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];
    public function get(FormatBARequest $request): JsonResponse
    {
        /**
         * Melakukan validasi data request
         * 
         */
        $data = $request->validated();

        /**
         * Memeriksa apakah data id_bayi ada
         * 
         */
        if (!empty($data['id_bayi'])) {

            /**
             * Mendapatkan informasi bayi
             * 
             */
            $bayi = BayiModel::select(
                'bayi.nama',
                'bayi.tanggal_lahir',
                'bayi.jenis_kelamin',
                'bayi.berat_lahir',
                'format_b.keterangan',
            )
                ->leftJoin('format_b', function ($join) {
                    $join->on('bayi.id', '=', 'format_b.id_bayi');
                })
                ->where('bayi.id', $data['id_bayi'])
                ->first();

            if ($bayi) {

                $tanggal_lahir = Carbon::parse($bayi->tanggal_lahir);

                // Mendapatkan tahun dan bulan bayi berumur 0 - 5 bulan
                $tahun_bulan_bayi = [];

                // Loop dari umur 0 hingga 5 bulan
                for ($i = 0; $i <= 5; $i++) {
                    $umur_bayi = $tanggal_lahir->copy()->addMonths($i);
                    $tahun_bulan_bayi[] = [
                        'tahun' => $umur_bayi->year,
                        'bulan' => $umur_bayi->month,
                    ];
                }

                // Konversi hasil ke dalam format yang diinginkan
                $list_waktu = [];
                foreach ($tahun_bulan_bayi as $tahun_bulan) {
                    $list_waktu[] = $tahun_bulan['tahun'] . ' ' . $this->namaBulan[$tahun_bulan['bulan']];
                }

            } else {

                throw new HttpResponseException(response()->json([
                    'errors' => [
                        'message' => 'Data tidak ditemukan'
                    ]
                ])->setStatusCode(400));
            }

            /**
             * Mendapatkan data penimbangan
             * 
             */
            $penimbangan = PenimbanganModel::select(
                'tahun_penimbangan',
                'bulan_penimbangan',
                'berat_badan',
                'ntob',
                'asi_ekslusif',
            )->where('id_bayi', '=', $data['id_bayi'])
                ->orderBy('tahun_penimbangan', 'asc')
                ->orderBy('bulan_penimbangan', 'asc')
                ->get();

            $list_penimbangan = array();
            for ($i = 0; $i < count($list_waktu); $i++) {

                $list_penimbangan[$i] = [
                    'judul' => 'Umur ' . $i . ' Bulan - ' . $list_waktu[$i],
                    'berat_badan' => null,
                    'ntob' => null,
                    'asi_ekslusif' => null,
                ];

                foreach ($penimbangan as $dataPenimbangan) {
                    if ($dataPenimbangan->tahun_penimbangan . ' ' . $this->namaBulan[$dataPenimbangan->bulan_penimbangan] == $list_waktu[$i]) {
                        $list_penimbangan[$list_waktu[$i]] = [
                            'judul' => 'Umur ' . $i . ' Bulan - ' . $list_waktu[$i],
                            'berat_badan' => $dataPenimbangan->berat_badan,
                            'ntob' => $dataPenimbangan->ntob,
                            'asi_ekslusif' => $dataPenimbangan->asi_ekslusif,
                        ];
                    }
                }
            }

            /**
             * Mengembalikan response sesuai request
             * 
             */
            return response()->json([
                "bayi" => $bayi,
                "penimbangan" => $list_penimbangan,
            ])->setStatusCode(200);
        }

        /**
         * Memeriksa apakah data request yang
         * dibutuhkan sudah tersedia
         * 
         */
        if (empty($data['tahun']) || empty($data['bulan'])) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'Data tahun dan bulan tidak boleh kosong'
                ]
            ])->setStatusCode(400));
        }

        /**
         * Membuat query utama
         * 
         */
        $query = BayiModel::select(
            'bayi.id as id_bayi',
            'bayi.nama as nama_bayi',
            'bayi.jenis_kelamin',
            'penimbangan.berat_badan',
            'penimbangan.ntob',
            'penimbangan.asi_ekslusif',
            'bayi.tanggal_lahir'
        )
            ->selectRaw('(' . $data['tahun'] . ' - YEAR(bayi.tanggal_lahir)) * 12 + ' . $data['bulan'] . ' - MONTH(bayi.tanggal_lahir) as umur')
            ->leftJoin('format_b', function ($join) {
                $join->on('bayi.id', '=', 'format_b.id_bayi');
            })
            ->leftJoin('penimbangan', function ($join) use ($data) {
                $join->on('bayi.id', '=', 'penimbangan.id_bayi')
                    ->whereRaw($data['bulan'] . ' - MONTH(bayi.tanggal_lahir) BETWEEN 0 AND 5');
            })
            ->whereRaw('(' . $data['tahun'] . ' - YEAR(bayi.tanggal_lahir)) * 12 + ' . $data['bulan'] . ' - MONTH(bayi.tanggal_lahir) BETWEEN 0 AND 5')
            ->whereNull('bayi.tanggal_meninggal');

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
            $query = $query->where('bayi.nama', 'LIKE', '%' . $data['search'] . '%');

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

            /**
             * Mengambil data gambar dari
             * query yang sudah difilter
             * 
             */
            $query = $query
                ->offset(($data['start'] - 1) * $data['length'])
                ->limit($data['length']);

        }

        /**
         * Mengambil data dari query dan
         * akan dijadikan response
         * 
         */
        $formatBA = $query->get();

        /**
         * Memeriksa apakah id_format_a ada
         * 
         */
        if (!empty($data['id_format_a'])) {

            /**
             * Mengambil query data sesuai id
             * 
             */
            $query = $query->where('format_a.id', $data['id_format_a']);

            /**
             * Mengambil data dari query dan
             * akan dijadikan response
             * 
             */
            $count = $query->count();
            $formatBA = $query->first();

        }

        /**
         * Mengembalikan response sesuai request
         * 
         */
        return response()->json([
            "jumlah_data" => $count,
            'judul_format' => $this->judulFormat,
            "format_ba" => $formatBA
        ])->setStatusCode(200);
    }
    public function post(FormatBARequest $request): JsonResponse
    {
        /**
         * Melakukan validasi data request
         * 
         */
        $data = $request->validated();

        $tahunBulan = explode(' ', explode(' - ', $data['judul'])[1]);
        $tahunPenimbangan = $tahunBulan[0];
        $bulanPenimbangan = array_search($tahunBulan[1], $this->namaBulan);

        /**
         * Memeriksa apakah data sudah ada sebelumnya
         * 
         */
        $dataAlready = PenimbanganModel::where('id_bayi', '=', $data['id_bayi'])
            ->where('tahun_penimbangan', '=', $tahunPenimbangan)
            ->where('bulan_penimbangan', '=', $bulanPenimbangan)
            ->first();

        if ($dataAlready) {

            /**
             * Melakukan ubah data jika data sudah ada
             * 
             */
            $dataAlready->update($data);

        } else {

            /**
             * Melakukan penambahan data jika data belum ada
             * 
             */
            PenimbanganModel::create($data);

        }

        /**
         * Mengembalikan response setelah
         * melakukan penambahan data
         * 
         */
        return response()->json([
            'success' => [
                'message' => 'Berhasil'
            ]
        ])->setStatusCode(201);
    }
}

// "waktu": [
//     "2022 Desember": [
//         "berat_badan": 10,
//         "ntob": "nt"
//     ],
//     "2023 Januari": [
//         "berat_badan": 10,
//         "ntob": "nt"
//     ],
//     "2023 Februari": [
//         "berat_badan": 10,
//         "ntob": "nt"
//     ],
//     "2023 Maret": [
//         "berat_badan": 10,
//         "ntob": "nt"
//     ],
//     "2023 April": [
//         "berat_badan": 10,
//         "ntob": "nt"
//     ],
//     "2023 Mei"
// ],