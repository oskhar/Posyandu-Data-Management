<?php

namespace Database\Factories;

use App\Models\BayiModel;
use App\Models\PenimbanganModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PenimbanganModel>
 */
class PenimbanganModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        while (true) {
            $this->definisiDataAwal();
            $umurBayi = (($this->tahun_penimbangan * 12) + $this->bulan_penimbangan) - (($this->bayi->tahun_lahir * 12) + $this->bayi->bulan_lahir);
            if ($umurBayi <= 30 && $umurBayi > 0)
                break;
        }
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
        $beratBadanBulanLalu = PenimbanganModel::select('penimbangan.berat_badan')
            ->where('penimbangan.id_bayi', $this->bayi->id)
            ->join('standar_deviasi', 'standar_deviasi.id', 'penimbangan.id_standar_deviasi')
            ->where('standar_deviasi.umur_bulan', $umurBayi - 1)
            ->value('berat_badan');
        $berat_badan = $this->randomFloat($dataWHO->sangat_kurus, $dataWHO->sangat_gemuk);
        $umurDataPertama = PenimbanganModel::select('standar_deviasi.umur_bulan')
            ->join('standar_deviasi', 'standar_deviasi.id', 'penimbangan.id_standar_deviasi')
            ->where('penimbangan.id_bayi', $this->bayi->id)
            ->where('penimbangan.berat_badan', '<>', '0')
            ->min('umur_bulan');
        $ntob = $this->getNTOB($umurBayi, $dataWHOBulanLalu, $dataWHO, $beratBadanBulanLalu, $berat_badan, $umurDataPertama);

        return [
            'id_bayi' => $this->bayi->id,
            'id_standar_deviasi' => $dataWHO->id,
            'tahun_penimbangan' => $this->tahun_penimbangan,
            'bulan_penimbangan' => $this->bulan_penimbangan,
            'berat_badan' => $berat_badan,
            'ntob' => $ntob,
            'asi_eksklusif' => ["Ya", "Tidak"][rand(0, 1)]
        ];
    }
}
