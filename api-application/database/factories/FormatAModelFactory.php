<?php

namespace Database\Factories;

use App\Models\BayiModel;
use App\Models\OrangTuaModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FormatAModel>
 */
class FormatAModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $orangTua = OrangTuaModel::create([
            "nama_ayah" => $this->faker->name,
            "nama_ibu" => $this->faker->name,
            "tanggal_meninggal_ibu" => [true, false][rand(0, 1)] ? $this->faker->date : null,
        ]);

        $bayi = BayiModel::create([
            "id_orang_tua" => $orangTua->id,
            "nama" => $this->faker->name,
            "jenis_kelamin" => ['L', 'P'][rand(0, 1)],
            "tanggal_lahir" => $this->faker->date,
            "tanggal_meninggal" => [true, false][rand(0, 1)] ? $this->faker->date : null,
        ]);

        return [
            "id_bayi" => $bayi->id,
            "keterangan" => $this->faker->paragraph,
        ];
    }
}
