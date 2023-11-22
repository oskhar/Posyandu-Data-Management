<?php

namespace Database\Seeders;

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
        \DB::table('edukasi')->insert([
            'id_admin' => 1,
            'judul' => 'Aidil salto',
            'materi' => 'Aidil salto merupakan kejadian yang sangat langka dan mungkin tidak pernah anda saksika seumur hidup anda',
            'gambar' => '/images/upload/default.png',
        ]);
        \DB::table('edukasi')->insert([
            'id_admin' => 1,
            'judul' => 'Nashif menjelajah planet mars',
            'materi' => 'Mars bukanlah planet layak huni yang bisa ditinggali oleh manusia, mars terlalu ekstrim untuk itu. untungnya nashif bukan manusia',
            'gambar' => '/images/upload/default.png',
        ]);
    }
}
