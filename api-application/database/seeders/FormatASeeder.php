<?php

namespace Database\Seeders;

use App\Models\BayiModel;
use App\Models\FormatAModel;
use App\Models\OrangTuaModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormatASeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // FormatAModel::factory(60000)->create();
        while (true) {
            $orangTua = OrangTuaModel::create([
                "nama_ayah" => fake()->name(),
                "nama_ibu" => fake()->name(),
                "tanggal_meninggal_ibu" => [true, false][rand(0, 1)] ? fake()->date() : null,
            ]);

            $bayi = BayiModel::create([
                "id_orang_tua" => $orangTua->id,
                "nama" => fake()->name(),
                "jenis_kelamin" => ['L', 'P'][rand(0, 1)],
                "tanggal_lahir" => fake()->date(),
                "tanggal_meninggal" => [true, false][rand(0, 1)] ? fake()->date() : null,
            ]);

            FormatAModel::create([
                "id_bayi" => $bayi->id,
                "keterangan" => fake()->paragraph(),
            ]);
        }
    }
}
