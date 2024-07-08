<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Memanggil semua seeder yang biasa
         * dipanggil secara terurut sesuai
         * referensi atau ketergantungan
         * tertentu tanpa merusak data.
         * 
         */
        $this->call([
            JabatanSeeder::class,
            AdminSeeder::class,
            PosyanduSeeder::class,
            BeratUmurSeeder::class,
            EdukasiSeeder::class,
            BeritaSeeder::class,
            FormatASeeder::class,
            WilayahSeeder::class,
        ]);
    }
}
