<?php

namespace Database\Seeders;

use App\Models\EdukasiModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EdukasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        EdukasiModel::factory(30)->create();
        // while (true) {
        //     EdukasiModel::create([
        //         'id_admin' => 1,
        //         'judul' => fake()->sentence(),
        //         'materi' => fake()->paragraph(),
        //         'gambar' => '/images/upload/default.png',
        //     ]);
        // }
    }
}
