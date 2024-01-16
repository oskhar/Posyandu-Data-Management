<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormatBARequest;
use App\Models\BayiModel;
use DB;
use App\Models\PenimbanganModel;
use App\Models\PosyanduModel;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FormatBAController extends Controller
{
    protected $batasBulanStart = [0, 6, 12, 24];
    protected $batasBulanEnd = [5, 11, 23, 59];
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

    protected $itemHasil = [
        'HB-0 24 JAM',
        'Vitamin',
        'BCG',
        'POLIO 1',
        'POLIO 2',
        'POLIO 3',
        'POLIO 4',
        'DPT-HB-HiB 1',
        'DPT-HB-HiB 2',
        'DPT-HB-HiB 3',
        'DPT-HB-HiB 4',
        'Inactivated Pollo Vaccine (IPV)',
        'Campak Rubella',
    ];
    protected $itemPelayanan = [
        'VIT A I',
        'VIT A II',
        'DPT-HB-HiB Lanjutan',
        'Campak Rubella Lanjutan',
        'Makanan Tambahan',
        'ORALIT',
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
                'bayi.hasil_penimbangan',
                'bayi.pelayanan',
                'orang_tua.nama_ayah',
                'orang_tua.nama_ibu',
                'bayi.berat_lahir',
                'format_b.keterangan',
            )
                ->join('orang_tua', 'orang_tua.id', 'bayi.id_orang_tua')
                ->selectRaw('bayi.tanggal_lahir')
                ->leftJoin('format_b', function ($join) {
                    $join->on('bayi.id', '=', 'format_b.id_bayi');
                })
                ->where('bayi.id', $data['id_bayi'])
                ->first();

            if ($bayi) {

                $tanggal_lahir = Carbon::parse($bayi->tanggal_lahir);

                $tahun_bulan_bayi = [];

                for ($i = 0; $i < 60; $i++) {
                    $umur_bayi = $tanggal_lahir->copy()->addMonths($i);
                    $tahun_bulan_bayi[] = [
                        'tahun' => $umur_bayi->year,
                        'bulan' => $umur_bayi->month,
                    ];
                }

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

            $tanggal_lahir = explode('-', $bayi->tanggal_lahir);
            $bayi->tanggal_lahir = $tanggal_lahir[2] . ' ' . $this->namaBulan[intval($tanggal_lahir[1])] . ' ' . $tanggal_lahir[0];

            /**
             * Mendapatkan data penimbangan
             * 
             */
            $penimbangan = PenimbanganModel::select(
                'tahun_penimbangan',
                'bulan_penimbangan',
                'berat_badan',
                'ntob',
                'asi_eksklusif',
                'lila',
                'lingkar_kepala',
                'tinggi_badan',
                'cara_ukur',
            )->where('id_bayi', '=', $data['id_bayi'])
                ->orderBy('tahun_penimbangan', 'asc')
                ->orderBy('bulan_penimbangan', 'asc')
                ->get();

            /**
             * Deklarasi list_penimbangan
             * 
             */
            $list_penimbangan = array();

            /**
             * Melakukan perulangan sebanyak data
             * 
             */
            for ($i = 0; $i < count($list_waktu); $i++) {

                $list_penimbangan[$i] = [
                    'judul' => 'Umur ' . $i . ' Bulan - ' . $list_waktu[$i],
                    'berat_badan' => null,
                    'ntob' => null,
                    'asi_eksklusif' => null,
                ];

                /**
                 * Melakukan perulangan sebanyak data yang tersedia
                 * 
                 */
                foreach ($penimbangan as $dataPenimbangan) {

                    /**
                     * Memeriksa kesamaan data penimbangan
                     * 
                     */
                    if ($dataPenimbangan->tahun_penimbangan . ' ' . $this->namaBulan[$dataPenimbangan->bulan_penimbangan] == $list_waktu[$i]) {

                        /**
                         * Memasukan data jika penimbangan ada
                         * 
                         */
                        $list_penimbangan[$i] = [
                            'judul' => 'Umur ' . $i . ' Bulan - ' . $list_waktu[$i],
                            'berat_badan' => $dataPenimbangan->berat_badan,
                            'ntob' => $dataPenimbangan->ntob,
                            'asi_eksklusif' => $dataPenimbangan->asi_eksklusif,
                            'lila' => $dataPenimbangan->lila,
                            'lingkar_kepala' => $dataPenimbangan->lingkar_kepala,
                            'tinggi_badan' => $dataPenimbangan->tinggi_badan,
                            'cara_ukur' => $dataPenimbangan->cara_ukur,
                        ];
                    }
                }

                /**
                 * Memeriksa apakah data selanjutnya null
                 * jika null, perulangan diberhentikan
                 * 
                 */
                if ($list_penimbangan[$i]['berat_badan'] == null && $list_penimbangan[$i]['asi_eksklusif'] != 'Alpa') {
                    break;
                }

            }

            /**
             * Mengambil standar deviasi dari
             * umur yang dipilih bulan ini
             * 
             */
            $dataWHO = DB::table('standar_deviasi')->select(
                'sangat_kurus',
                'kurus',
                'normal_kurus',
                'baik',
                'normal_gemuk',
                'gemuk',
                'sangat_gemuk'
            )->where('id_berat_untuk_umur', $bayi->jenis_kelamin == 'L' ? 1 : 2)
                ->limit(count($list_penimbangan))
                ->get();

            /**
             * Mengambil keseluruhan data series
             * 
             */
            $series = [
                [
                    "name" => "Terlalu Gemuk",
                    "type" => "line",
                    "data" => $dataWHO->map(function ($item) {
                        return $item->sangat_gemuk;
                    }),
                ],
                [
                    "name" => "Berat Gemuk",
                    "type" => "line",
                    "data" => $dataWHO->map(function ($item) {
                        return $item->gemuk;
                    }),
                ],
                [
                    "name" => "Berat Normal",
                    "type" => "line",
                    "data" => $dataWHO->map(function ($item) {
                        return $item->normal_gemuk;
                    }),
                ],
                [
                    "name" => "Berat Baik",
                    "type" => "line",
                    "data" => $dataWHO->map(function ($item) {
                        return $item->baik;
                    }),
                ],
                [
                    "name" => "Berat Normal",
                    "type" => "line",
                    "data" => $dataWHO->map(function ($item) {
                        return $item->normal_kurus;
                    }),
                ],
                [
                    "name" => "Berat Kurus",
                    "type" => "line",
                    "data" => $dataWHO->map(function ($item) {
                        return $item->kurus;
                    }),
                ],
                [
                    "name" => "Terlalu Kurus, butuh penanganan",
                    "type" => "line",
                    "data" => $dataWHO->map(function ($item) {
                        return $item->sangat_kurus;
                    }),
                ],
                [
                    "name" => "Berat bayi",
                    "type" => "line",
                    "data" =>
                        PenimbanganModel::select('berat_badan')
                            ->where('id_bayi', $data['id_bayi'])
                            ->get()->map(function ($item) {
                                return $item->berat_badan == 0 ? null : $item->berat_badan;
                            })->toArray(),
                ],
            ];

            $hasilPenimbangan = [];
            $pelayanan = [];

            if (!empty($bayi->hasil_penimbangan)) {
                /**
                 * Menyatukan array hasil penimbangan
                 * kedalam bentuk string
                 * 
                 */
                $hasilPenimbangan = explode(', ', $bayi->hasil_penimbangan);

                /**
                 * Melakukan map array pada hasil penimbangan
                 * mengubah text menjadi kumpulan index
                 * 
                 */
                $hasilPenimbangan = array_map(function ($item) {
                    return $this->itemHasil[$item];
                }, $hasilPenimbangan);
            }

            if (!empty($bayi->pelayanan)) {
                /**
                 * Menyatukan array pelayanan
                 * kedalam bentuk string
                 * 
                 */
                $pelayanan = explode(', ', $bayi->pelayanan);

                /**
                 * Melakukan map array pada pelayanan
                 * text menjadi kumpulan index
                 * 
                 */
                $pelayanan = array_map(function ($item) {
                    return $this->itemPelayanan[$item];
                }, $pelayanan);
            }

            /**
             * Mengembalikan response sesuai request
             * 
             */
            return response()->json([
                "bayi" => $bayi,
                "penimbangan" => $list_penimbangan,
                "series" => $series,
                "hasil_penimbangan" => $hasilPenimbangan,
                "pelayanan" => $pelayanan,
            ])->setStatusCode(200);
        }

        /**
         * Memeriksa apakah data request yang
         * dibutuhkan sudah tersedia
         * 
         */
        if (empty($data['tahun'])) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'Data tahun tidak boleh kosong'
                ]
            ])->setStatusCode(400));
        }

        /**
         * Memeriksa apakah data tab ada di request
         * 
         */
        if (empty($data['tab'])) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'Data tab tidak boleh kosong'
                ]
            ])->setStatusCode(400));
        }

        /**
         * Membuat query utama
         * 
         */
        $queries = [];
        for ($bulan = 1; $bulan <= 12; $bulan++) {

            $queries[$bulan - 1] = BayiModel::select(
                'bayi.id as id_bayi',
                'bayi.nama as nama_bayi',
                'bayi.jenis_kelamin',
                'penimbangan.berat_badan',
                'penimbangan.ntob',
                'penimbangan.asi_eksklusif'
            )
                ->selectRaw('"' . $this->namaBulan[$bulan] . '" as bulan')
                ->selectRaw('(' . $data['tahun'] . ' - YEAR(bayi.tanggal_lahir)) * 12 + ' . $bulan . ' - MONTH(bayi.tanggal_lahir) as umur')
                ->leftJoin('penimbangan', function ($join) use ($data, $bulan) {
                    $join->on('penimbangan.id_bayi', '=', 'bayi.id')
                        ->where('penimbangan.tahun_penimbangan', $data['tahun'])
                        ->where('penimbangan.bulan_penimbangan', $bulan);
                })
                ->whereRaw('(' . $data['tahun'] . ' - YEAR(bayi.tanggal_lahir)) * 12 + ' . $bulan . ' - MONTH(bayi.tanggal_lahir) BETWEEN ' . $this->batasBulanStart[$data['tab'] - 1] . ' AND ' . $this->batasBulanEnd[$data['tab'] - 1])
                ->whereNull('bayi.tanggal_meninggal');

        }

        /**
         * Melakukan perulangan dari queries
         * 
         */
        foreach ($queries as $index => $query) {

            /**
             * Memeriksa query utama
             * 
             */
            if ($index === 0) {

                /**
                 * Tetapkan index 0 menjadi query utama
                 * 
                 */
                $mergedQuery = $query;

            } else {

                /**
                 * Menambahkan query lainnya untuk
                 * distak ke dalam query utama
                 * 
                 */
                $mergedQuery = $mergedQuery->union($query);
            }
        }

        /**
         * Assigment query yang dimerge kedalam
         * query yang akan dipanggil nantinya
         * 
         */
        $query = $mergedQuery;


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
         * Mengambil data posyandu
         * 
         */
        $posyandu = PosyanduModel::select(
            'nama_posyandu',
            'kota'
        )->first();

        /**
         * Assigment judul format
         * 
         */
        $judulFormat = 'Regrister bayi (' . $this->batasBulanStart[$data['tab'] - 1] . ' - ' . $this->batasBulanEnd[$data['tab'] - 1] . ' bulan) dalam wilayah kerja posyandu Januari - Desember';

        /**
         * Mengembalikan response sesuai request
         * 
         */
        return response()->json([
            'nama_posyandu' => $posyandu->nama_posyandu,
            'kota' => $posyandu->kota,
            "jumlah_data" => $count,
            'judul_format' => $judulFormat,
            "format_ba" => $formatBA
        ])->setStatusCode(200);
    }
    public function post(FormatBARequest $request): JsonResponse
    {
        /**
         * Melakukan validasi data request
         * 
         */
        $allData = $request->validated();

        /**
         * Menetapkan id bayi
         */
        $idBayi = $allData['id_bayi'];

        /**
         * Menetapkan isi pesan response nanti
         */
        $errorField = array();
        $pesan = [
            'success' => [
                'message' => 'Berhasil',
            ]
        ];
        foreach ($allData['penimbangan'] as $index => $data) {

            /**
             * Memeriksa apakah data valid
             * 
             */
            if (empty($data['asi_eksklusif']) && is_null($data['berat_badan'])) {
                break;
            }
            if ($data['berat_badan'] < 0) {
                throw new HttpResponseException(response()->json([
                    'errors' => [
                        'message' => 'Berat badan tidak boleh negatif'
                    ]
                ])->setStatusCode(400));
            }

            /**
             * Mengambil tahun dan bulan dari data judul
             * 
             */
            $dataJudul = explode(' - ', $data['judul']);
            $umurBayi = explode(' ', $dataJudul[0])[1];
            $tahunBulan = explode(' ', $dataJudul[1]);
            $tahunPenimbangan = $tahunBulan[0];
            $bulanPenimbangan = array_search($tahunBulan[1], $this->namaBulan);

            /**
             * Menghabpus data judul
             * 
             */
            unset($data['judul']);

            /**
             * Menambahkan tahun dan bulan ke dalam data
             * 
             */
            $data['tahun_penimbangan'] = intval($tahunPenimbangan);
            $data['bulan_penimbangan'] = intval($bulanPenimbangan);

            /**
             * Mengambil jenis kelamin bayi
             * 
             */
            $jenisKelamin = BayiModel::select('jenis_kelamin')
                ->where('id', $idBayi)->first()->jenis_kelamin;

            /**
             * Mengambil standar deviasi dari WHO
             * 
             */
            $dataWHO = DB::table('standar_deviasi')->select(
                'id',
                'sangat_kurus',
                'kurus',
                'normal_kurus',
                'baik',
                'normal_gemuk',
                'gemuk',
                'sangat_gemuk'
            )->where('id_berat_untuk_umur', $jenisKelamin == 'L' ? 1 : 2)
                ->where('umur_bulan', $umurBayi)->first();

            $data['id_standar_deviasi'] = $dataWHO->id;

            /**
             * Mengambil standar deviasi dari WHO
             * Untuk berat badan umur bulan lalu
             * 
             */
            $dataWHOBulanLalu = DB::table('standar_deviasi')->select(
                'sangat_kurus',
                'kurus',
                'normal_kurus',
                'baik',
                'normal_gemuk',
                'gemuk',
                'sangat_gemuk'
            )->where('id_berat_untuk_umur', $jenisKelamin == 'L' ? 1 : 2)
                ->where('umur_bulan', $umurBayi - 1)->first();

            /**
             * Mengambil data berat badan bulan lalu
             * 
             */
            $beratBadanBulanLalu = PenimbanganModel::select('penimbangan.berat_badan')
                ->where('penimbangan.id_bayi', $idBayi)
                ->join('standar_deviasi', 'standar_deviasi.id', 'penimbangan.id_standar_deviasi')
                ->where('standar_deviasi.umur_bulan', $umurBayi - 1)
                ->value('berat_badan');

            /**
             * Jika data berat badan dan data
             * asi_ekslisif tidak relevan
             * 
             */
            if ($data['asi_eksklusif'] == "Alpa" && $data['berat_badan'] != 0) {

                /**
                 * Memeberikan peringatan
                 * 
                 */
                $pesan = [
                    'warning' => [
                        'message' => 'Jika alpa, berat badan akan dikosongkan !!',
                    ]
                ];

                /**
                 * Menambahkan data errorField untuk
                 * memberi tau bagian yang diisi
                 * dengan tidak sesuai oleh user
                 * 
                 */
                array_push($errorField, $index);

            }

            /**
             * Mendapatkan data pertama
             * 
             */
            $umurDataPertama = PenimbanganModel::select('standar_deviasi.umur_bulan')
                ->join('standar_deviasi', 'standar_deviasi.id', 'penimbangan.id_standar_deviasi')
                ->where('penimbangan.id_bayi', $idBayi)
                ->where('penimbangan.berat_badan', '<>', '0')
                ->min('umur_bulan');

            /**
             * Memeriksa apakah data kosong
             * 
             */
            if ($data['asi_eksklusif'] == "Alpa" || $data['berat_badan'] == 0) {

                /**
                 * Atur semua data yang tidak
                 * relevan secara paksa
                 * 
                 */
                $data['ntob'] = "Kosong";
                $data['berat_badan'] = 0;
                $data['asi_eksklusif'] = "Alpa";

            } else {

                /**
                 * Ambil data NTOB sesuai dengan perhitungan
                 * 
                 */
                $data['ntob'] = $this->getNTOB($umurBayi, $dataWHOBulanLalu, $dataWHO, $beratBadanBulanLalu, $data['berat_badan'], $umurDataPertama);

            }

            /**
             * Menggunakan updateOrCreate untuk menyimpan atau memperbarui data
             * 
             */
            PenimbanganModel::updateOrCreate(
                [
                    'id_bayi' => $idBayi,
                    'tahun_penimbangan' => $tahunPenimbangan,
                    'bulan_penimbangan' => $bulanPenimbangan,
                ],
                $data
            );
        }
        $pesan = array_merge($pesan, [
            'error_field' => $errorField
        ]);

        /**
         * Mengembalikan response setelah
         * melakukan penambahan data
         * 
         */
        return response()->json(
            $pesan
        )->setStatusCode(201);
    }
    protected function getNTOB($umurBayi, $dataWHOBulanLalu, $dataWHO, $beratBadanBulanLalu, $beratBadanSekarang, $umurDataPertama)
    {

        /**
         * Memeriksa apakah berat bayi tersedia
         * 
         */
        if (is_null($umurDataPertama) || $umurBayi <= $umurDataPertama) {

            /**
             * Menetapkan nilai ntob sebagai B jika bayi
             * baru pertama kali menimbang di posyandu
             * 
             */
            return "B (Baru pertama kali menimbang)";

        } else if (empty($beratBadanBulanLalu)) {

            /**
             * Mengembalikan O jika bulan lalu bayi
             * tidak melakukan penimbangan
             * 
             */
            return "O (Tidak menimbang bulan lalu)";

        } else {

            /**
             * Mendapatkan pita berat bulan lalu
             * 
             */
            $pitaBulanLalu = $this->getPitaBeratBadan($beratBadanBulanLalu, $dataWHOBulanLalu);

            /**
             * Mendapatkan pita berat bulan sekarang
             * 
             */
            $pitaBulanIni = $this->getPitaBeratBadan($beratBadanSekarang, $dataWHO);

            /**
             * Membandingkan pita bulan ini dengan
             * pita bulan lalu
             * 
             */
            if ($pitaBulanIni == 0) {

                /**
                 * Mengembalikan response BGM karena bayi
                 * berada di pita paling bawah berat
                 * bayi berada di zona bahaya
                 * 
                 */
                return "BGM (Bayi butuh penanganan khusus)";

            } else if ($beratBadanSekarang > $beratBadanBulanLalu && $pitaBulanIni >= $pitaBulanLalu) {

                /**
                 * Kembalikan N1 Jika berat bayi masuk ke
                 * pita diatasnya dan berat badan lebih
                 * tinggi dari bulan lalu
                 * 
                 */
                return "N" . ($pitaBulanIni > $pitaBulanLalu ? "1 (Naik, Masuk pita diatasnya)" : "2 (Naik, Tetap pada pita yang sama)");

            }

        }

        /**
         * Mengembalikan response T yang menandakan
         * bahwa berat bayi berada di zona waspada
         * 
         */
        return "T" . ($beratBadanSekarang > $beratBadanBulanLalu ? "1 (Naik, Namun masuk ke pita bawahnya)" : ($beratBadanSekarang == $beratBadanBulanLalu ? "2 (Tetap, Tidak mengalami pertumbuah)" : "3 (Turun, Tumbuh negatif)"));
    }
    private function getPitaBeratBadan($beratBadan, $dataWHO)
    {
        /**
         * Memeriksa berat bayi berada di pita mana
         * 
         */
        if ($beratBadan > $dataWHO->sangat_gemuk) {

            return 7;

        } elseif ($beratBadan > $dataWHO->gemuk) {

            return 6;

        } elseif ($beratBadan > $dataWHO->normal_gemuk) {

            return 5;

        } elseif ($beratBadan > $dataWHO->baik) {

            return 4;

        } elseif ($beratBadan > $dataWHO->normal_kurus) {

            return 3;

        } elseif ($beratBadan > $dataWHO->kurus) {

            return 2;

        } elseif ($beratBadan > $dataWHO->sangat_kurus) {

            return 1;

        } else {

            return 0;

        }
    }
    public function getListTahun(Request $request): JsonResponse
    {
        /**
         * Memeriksa apakah request tab ada
         * 
         */
        if (empty($request->tab)) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'Data tab tidak boleh kosong'
                ]
            ])->setStatusCode(400));
        }
        /**
         * Mendapatkan tahun terkecil dan terbesar
         * yang ada di database
         * 
         */
        $listTahunLahir = BayiModel::selectRaw('MIN(YEAR(tanggal_lahir) + FLOOR((MONTH(tanggal_lahir) + ' . $this->batasBulanStart[intval($request->tab) - 1] . ') / 12)) as min_tahun')
            ->selectRaw('MAX(YEAR(tanggal_lahir) + FLOOR((MONTH(tanggal_lahir) + ' . $this->batasBulanEnd[intval($request->tab) - 1] . ') / 12)) as max_tahun')
            ->first();

        /**
         * Mendapatkan seluruh list tahun berdasarkan
         * range dari tahun terkecil dan terbesar
         * 
         */
        $listTahunLahir = range($listTahunLahir->min_tahun, $listTahunLahir->max_tahun);

        /**
         * Mengembalikan response setelah
         * melakukan penambahan data
         * 
         */
        return response()->json(
            $listTahunLahir,
        )->setStatusCode(200);
    }
    public function put(Request $request): JsonResponse
    {
        /**
         * Melakukan map array pada hasil penimbangan
         * mengubah text menjadi kumpulan index
         * 
         */
        $hasil = array_map(function ($item) {
            return array_search($item, $this->itemHasil);
        }, $request->hasil_penimbangan);

        /**
         * Menyatukan array hasil penimbangan
         * kedalam bentuk string
         * 
         */
        $hasil = implode(', ', $hasil);

        /**
         * Melakukan map array pada pelayanan
         * text menjadi kumpulan index
         * 
         */
        $pelayanan = array_map(function ($item) {
            return array_search($item, $this->itemPelayanan);
        }, $request->pelayanan);

        /**
         * Menyatukan array pelayanan
         * kedalam bentuk string
         * 
         */
        $pelayanan = implode(', ', $pelayanan);

        /**
         * Melakukan pengubahan data bayi
         * 
         */
        BayiModel::where('id', $request->id_bayi)
            ->update([
                'hasil_penimbangan' => $hasil,
                'pelayanan' => $pelayanan,
            ]);

        /**
         * Mengembalikan response setelah
         * melakukan penambahan data
         * 
         */
        return response()->json([
            'success' => [
                'message' => 'Berhasil update data!'
            ]
        ])->setStatusCode(200);
    }
    public function apiTesting(): JsonResponse
    {
        $bulan = 1;
        $tahun = 2024;

        for ($i = 0; $i < 4; $i++) {

            $query = BayiModel::whereRaw('(' . $tahun . ' - YEAR(bayi.tanggal_lahir)) * 12 + ' . $bulan . ' - MONTH(bayi.tanggal_lahir) BETWEEN ' . $this->batasBulanStart[$i] . ' AND ' . $this->batasBulanEnd[$i]);

            $S[$i] = $query->count();
            $SP[$i] = $query->where('jenis_kelamin', 'P')
                ->count();
            $SL[$i] = $S[$i] - $SP[$i];

            $query = BayiModel::whereRaw('(' . $tahun . ' - YEAR(bayi.tanggal_lahir)) * 12 + ' . $bulan . ' - MONTH(bayi.tanggal_lahir) BETWEEN ' . $this->batasBulanStart[$i] . ' AND ' . $this->batasBulanEnd[$i])
                ->where('memiliki_kms', '1');

            $K[$i] = $query->count();
            $KP[$i] = $query->where('jenis_kelamin', 'P')
                ->count();
            $KL[$i] = $K[$i] - $KP[$i];

            $query = PenimbanganModel::join('standar_deviasi', 'standar_deviasi.id', 'penimbangan.id_standar_deviasi')
                ->where('penimbangan.tahun_penimbangan', $tahun)
                ->where('penimbangan.bulan_penimbangan', $bulan)
                ->whereRaw('SUBSTRING(penimbangan.ntob FROM 1 FOR 1) = "N"')
                ->whereRaw('standar_deviasi.umur_bulan BETWEEN ' . $this->batasBulanStart[$i] . ' AND ' . $this->batasBulanEnd[$i]);

            $N[$i] = $query->count();
            $NP[$i] = $query->where('id_berat_untuk_umur', 2)->count();
            $NL[$i] = $N[$i] - $NP[$i];

            $query = PenimbanganModel::join('standar_deviasi', 'standar_deviasi.id', 'penimbangan.id_standar_deviasi')
                ->where('penimbangan.tahun_penimbangan', $tahun)
                ->where('penimbangan.bulan_penimbangan', $bulan)
                ->whereRaw('SUBSTRING(penimbangan.ntob FROM 1 FOR 1) = "T"')
                ->whereRaw('standar_deviasi.umur_bulan BETWEEN ' . $this->batasBulanStart[$i] . ' AND ' . $this->batasBulanEnd[$i]);

            $T[$i] = $query->count();
            $TP[$i] = $query->where('id_berat_untuk_umur', 2)->count();
            $TL[$i] = $T[$i] - $TP[$i];

            $query = PenimbanganModel::join('standar_deviasi', 'standar_deviasi.id', 'penimbangan.id_standar_deviasi')
                ->where('penimbangan.tahun_penimbangan', $tahun)
                ->where('penimbangan.bulan_penimbangan', $bulan)
                ->whereRaw('SUBSTRING(penimbangan.ntob FROM 1 FOR 1) = "O"')
                ->whereRaw('standar_deviasi.umur_bulan BETWEEN ' . $this->batasBulanStart[$i] . ' AND ' . $this->batasBulanEnd[$i]);

            $O[$i] = $query->count();
            $OP[$i] = $query->where('id_berat_untuk_umur', 2)->count();
            $OL[$i] = $O[$i] - $OP[$i];

            $query = PenimbanganModel::join('standar_deviasi', 'standar_deviasi.id', 'penimbangan.id_standar_deviasi')
                ->where('penimbangan.tahun_penimbangan', $tahun)
                ->where('penimbangan.bulan_penimbangan', $bulan)
                ->whereRaw('SUBSTRING(penimbangan.ntob FROM 1 FOR 1) = "B"')
                ->whereRaw('standar_deviasi.umur_bulan BETWEEN ' . $this->batasBulanStart[$i] . ' AND ' . $this->batasBulanEnd[$i]);

            $B[$i] = $query->count();
            $BP[$i] = $query->where('id_berat_untuk_umur', 2)->count();
            $BL[$i] = $B[$i] - $BP[$i];

            $D[$i] = $N[$i] + $T[$i] + $O[$i] + $B[$i];
            $DP[$i] = $NP[$i] + $TP[$i] + $OP[$i] + $BP[$i];
            $DL[$i] = $NL[$i] + $TL[$i] + $OL[$i] + $BL[$i];

            $ST[$i] = $S[$i] - $D[$i];
            $STP[$i] = $SP[$i] - $DP[$i];
            $STL[$i] = $SL[$i] - $DL[$i];



            $tahunLalu = ($bulan - 1 == 0) ? $tahun - 1 : $tahun;
            $bulanLalu = ($bulan - 1 == 0) ? 12 : $bulan - 1;

            $query = PenimbanganModel::join('standar_deviasi', 'standar_deviasi.id', 'penimbangan.id_standar_deviasi')
                ->where('penimbangan.tahun_penimbangan', $tahunLalu)
                ->where('penimbangan.bulan_penimbangan', $bulanLalu)
                ->whereRaw('SUBSTRING(penimbangan.ntob FROM 1 FOR 1) = "T"')
                ->whereRaw('standar_deviasi.umur_bulan BETWEEN ' . ($this->batasBulanStart[$i] + 1) . ' AND ' . $this->batasBulanEnd[$i]);

            $TT[$i] = $query->count();
            $TTP[$i] = $query->where('id_berat_untuk_umur', 2)->count();
            $TTL[$i] = $TT[$i] - $TTP[$i];

            $DOB[$i] = $D[$i] - $O[$i] - $B[$i];
            $DOBP[$i] = $DP[$i] - $OP[$i] - $BP[$i];
            $DOBL[$i] = $DL[$i] - $OL[$i] - $BL[$i];

            $query = PenimbanganModel::join('standar_deviasi', 'standar_deviasi.id', 'penimbangan.id_standar_deviasi')
                ->where('penimbangan.tahun_penimbangan', $tahun)
                ->where('penimbangan.bulan_penimbangan', $bulan)
                ->whereRaw('SUBSTRING(penimbangan.ntob FROM 1 FOR 3) = "BGM"')
                ->whereRaw('standar_deviasi.umur_bulan BETWEEN ' . $this->batasBulanStart[$i] . ' AND ' . $this->batasBulanEnd[$i]);

            $BGM[$i] = $query->count();
            $BGMP[$i] = $query->where('id_berat_untuk_umur', 2)->count();
            $BGML[$i] = $BGM[$i] - $BGMP[$i];

        }

        $result = [
            [
                $SL[0],
                $SP[0],
                $S[0],
                $SL[1],
                $SP[1],
                $S[1],
                $SL[2],
                $SP[2],
                $S[2],
                $SL[3],
                $SP[3],
                $S[3],
            ],
            [
                $KL[0],
                $KP[0],
                $K[0],
                $KL[1],
                $KP[1],
                $K[1],
                $KL[2],
                $KP[2],
                $K[2],
                $KL[3],
                $KP[3],
                $K[3],
            ],
            [
                $NL[0],
                $NP[0],
                $N[0],
                $NL[1],
                $NP[1],
                $N[1],
                $NL[2],
                $NP[2],
                $N[2],
                $NL[3],
                $NP[3],
                $N[3],
            ],
            [
                $TL[0],
                $TP[0],
                $T[0],
                $TL[1],
                $TP[1],
                $T[1],
                $TL[2],
                $TP[2],
                $T[2],
                $TL[3],
                $TP[3],
                $T[3],
            ],
            [
                $OL[0],
                $OP[0],
                $O[0],
                $OL[1],
                $OP[1],
                $O[1],
                $OL[2],
                $OP[2],
                $O[2],
                $OL[3],
                $OP[3],
                $O[3],
            ],
            [
                $BL[0],
                $BP[0],
                $B[0],
                $BL[1],
                $BP[1],
                $B[1],
                $BL[2],
                $BP[2],
                $B[2],
                $BL[3],
                $BP[3],
                $B[3],
            ],
            [
                $DL[0],
                $DP[0],
                $D[0],
                $DL[1],
                $DP[1],
                $D[1],
                $DL[2],
                $DP[2],
                $D[2],
                $DL[3],
                $DP[3],
                $D[3],
            ],
            [
                $STL[0],
                $STP[0],
                $ST[0],
                $STL[1],
                $STP[1],
                $ST[1],
                $STL[2],
                $STP[2],
                $ST[2],
                $STL[3],
                $STP[3],
                $ST[3],
            ],
            [
                $TTL[0],
                $TTP[0],
                $TT[0],
                $TTL[1],
                $TTP[1],
                $TT[1],
                $TTL[2],
                $TTP[2],
                $TT[2],
                $TTL[3],
                $TTP[3],
                $TT[3],
            ],
            [
                $DOBL[0],
                $DOBP[0],
                $DOB[0],
                $DOBL[1],
                $DOBP[1],
                $DOB[1],
                $DOBL[2],
                $DOBP[2],
                $DOB[2],
                $DOBL[3],
                $DOBP[3],
                $DOB[3],
            ],
            [
                $BGML[0],
                $BGMP[0],
                $BGM[0],
                $BGML[1],
                $BGMP[1],
                $BGM[1],
                $BGML[2],
                $BGMP[2],
                $BGM[2],
                $BGML[3],
                $BGMP[3],
                $BGM[3],
            ],
        ];

        /**
         * Mengembalikan response sesuai request
         * 
         */
        return response()->json(
            $result
        )->setStatusCode(200);
    }
}
