<?php

namespace Database\Factories;

use App\Models\BayiModel;
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
        return [
            'id_bayi' => BayiModel::inRandomOrder()->value('id', ),
            'tahun_penimbangan' => rand(2021, 2023) . '',
            'bulan_penimbangan' => ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ][rand(0, 11)],
            'berat_badan' => 3,
            'ntob' => $this->faker->name,
            'asi_ekslusif' => $this->faker->name,
        ];
    }
}
