<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class EdukasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // EdukasiModel::factory(30)->create();
        // while (true) {
        //     EdukasiModel::create([
        //         'id_admin' => 1,
        //         'judul' => fake()->sentence(),
        //         'materi' => fake()->paragraph(),
        //         'gambar' => '/images/upload/default.png',
        //     ]);
        // }

        // Seeder untuk tabel edukasi
        $educations = [
            [
                'id_admin' => 1,
                'judul' => 'Cegah Cacingan',
                'materi' => 'Materi tentang pencegahan cacingan pada anak.',
                'gambar' => '/images/upload/Cegah_Cacingan.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_admin' => 2,
                'judul' => 'Pentingnya Penimbangan Balita Setiap Bulan',
                'materi' => 'Materi tentang pentingnya penimbangan balita setiap bulan.',
                'gambar' => '/images/upload/Pentingnya_Penimbangan_Balita_Setiap_Bulan.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_admin' => 1,
                'judul' => 'Mari ke Posyandu',
                'materi' => 'Materi yang mengajak masyarakat untuk datang ke posyandu.',
                'gambar' => '/images/upload/Mari_ke_Posyandu.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_admin' => 2,
                'judul' => 'Periksa Tumbuh Kembang Anak Sejak Dini',
                'materi' => 'Materi tentang pentingnya memeriksa tumbuh kembang anak sejak dini.',
                'gambar' => '/images/upload/Periksa_Tumbuh_Kembang_Anak_Sejak_Dini.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('edukasi')->insert($educations);
    }
}
