<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PosyanduSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        \DB::table('posyandu')->insert([
            'nama_posyandu' => 'Posyandu Melati',
            'kota' => 'Periuk',
            'kecamatan' => 'Periuk',
            'kelurahan' => 'Periuk',
            'penyampaian_ketua' => 'Belum ada',
            'gambar_gedung' => '/images/upload/default.png',
            'visi' => 'Belum ada',
            'misi' => 'Belum ada',
            'rt_rw' => '01/001',
        ]);
    }
}
