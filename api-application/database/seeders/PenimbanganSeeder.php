<?php

namespace Database\Seeders;

use App\Models\BayiModel;
use App\Models\PenimbanganModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenimbanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($idBayi = 1; $idBayi <= 18; $idBayi++) {
            // Ambil data bayi berdasarkan ID
            $this->bayi = BayiModel::select('id', 'jenis_kelamin', \DB::raw('YEAR(tanggal_lahir) as tahun_lahir'), \DB::raw('MONTH(tanggal_lahir) as bulan_lahir'))
                ->where("id", $idBayi)
                ->first();

            // Hitung total bulan dari tanggal lahir + 30 bulan (batas penimbangan 30 bulan)
            $totalBulanPenimbangan = ($this->bayi->tahun_lahir * 12) + $this->bayi->bulan_lahir + 30;

            // Loop untuk melakukan penimbangan selama 30 bulan dari lahir
            $currentBulanPenimbangan = ($this->bayi->tahun_lahir * 12) + $this->bayi->bulan_lahir; // Mulai dari bulan lahir bayi

            while ($currentBulanPenimbangan < $totalBulanPenimbangan) {
                // Konversi bulan total menjadi tahun dan bulan penimbangan
                $this->tahun_penimbangan = intdiv($currentBulanPenimbangan, 12);  // Tahun penimbangan
                $this->bulan_penimbangan = $currentBulanPenimbangan % 12;  // Bulan penimbangan

                // Koreksi jika $bulan_penimbangan == 0 (artinya Desember)
                if ($this->bulan_penimbangan == 0) {
                    $this->bulan_penimbangan = 12;
                    $this->tahun_penimbangan -= 1;
                }

                // Hitung umur bayi dalam bulan
                $umurBayi = $currentBulanPenimbangan - (($this->bayi->tahun_lahir * 12) + $this->bayi->bulan_lahir);

                // Ambil data standar deviasi WHO berdasarkan umur bayi dan jenis kelamin
                $dataWHO = \DB::table('standar_deviasi')->select(
                    'id',
                    'sangat_kurus',
                    'kurus',
                    'normal_kurus',
                    'baik',
                    'normal_gemuk',
                    'gemuk',
                    'sangat_gemuk'
                )->where('id_berat_untuk_umur', $this->bayi->jenis_kelamin == 'L' ? 1 : 2)
                    ->where('umur_bulan', $umurBayi)->first();

                // Ambil data penimbangan bulan lalu
                $dataWHOBulanLalu = \DB::table('standar_deviasi')->select(
                    'sangat_kurus',
                    'kurus',
                    'normal_kurus',
                    'baik',
                    'normal_gemuk',
                    'gemuk',
                    'sangat_gemuk'
                )->where('id_berat_untuk_umur', $this->bayi->jenis_kelamin == 'L' ? 1 : 2)
                    ->where('umur_bulan', $umurBayi - 1)->first();

                // Ambil berat badan bulan lalu dari tabel penimbangan
                $beratBadanBulanLalu = PenimbanganModel::select('penimbangan.berat_badan')
                    ->where('penimbangan.id_bayi', $this->bayi->id)
                    ->join('standar_deviasi', 'standar_deviasi.id', 'penimbangan.id_standar_deviasi')
                    ->where('standar_deviasi.umur_bulan', $umurBayi - 1)
                    ->value('berat_badan');

                // Random berat badan saat ini antara sangat kurus dan sangat gemuk
                $berat_badan = $this->randomFloat($dataWHO->sangat_kurus, $dataWHO->sangat_gemuk);

                // Ambil umur data pertama yang tersedia dari penimbangan
                $umurDataPertama = PenimbanganModel::select('standar_deviasi.umur_bulan')
                    ->join('standar_deviasi', 'standar_deviasi.id', 'penimbangan.id_standar_deviasi')
                    ->where('penimbangan.id_bayi', $this->bayi->id)
                    ->where('penimbangan.berat_badan', '<>', '0')
                    ->min('umur_bulan');

                // Hitung NTOb
                $ntob = $this->getNTOB($umurBayi, $dataWHOBulanLalu, $dataWHO, $beratBadanBulanLalu, $berat_badan, $umurDataPertama);

                // Insert data penimbangan
                PenimbanganModel::create([
                    'id_bayi' => $this->bayi->id,
                    'id_standar_deviasi' => $dataWHO->id,
                    'tahun_penimbangan' => $this->tahun_penimbangan,
                    'bulan_penimbangan' => $this->bulan_penimbangan,
                    'berat_badan' => $berat_badan,
                    'ntob' => $ntob,
                    'asi_eksklusif' => ["Ya", "Tidak"][rand(0, 1)]
                ]);

                // Increment untuk bulan penimbangan selanjutnya
                $currentBulanPenimbangan++;
            }
        }
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
    private function randomFloat($min, $max)
    {
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    }
    private $bayi;
    private $tahun_penimbangan;
    private $bulan_penimbangan;
    private function definisiDataAwal()
    {
        $this->tahun_penimbangan = rand($this->bayi->tahun_lahir, 2024);
        $this->bulan_penimbangan = ($this->tahun_penimbangan == $this->bayi->tahun_lahir)
            ? rand($this->bayi->bulan_lahir, max: 12)
            : rand(1, 12);
    }
}
