<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        \DB::table('jabatan')->insert([
            'nama' => 'PELINDUNG',
            'level' => '1'
        ]);

        \DB::table('jabatan')->insert([
            'nama' => 'PENANGGUNG JAWAB',
            'level' => '2'
        ]);

        \DB::table('jabatan')->insert([
            'nama' => 'SEKRETARIS',
            'level' => '3'
        ]);
        \DB::table('jabatan')->insert([
            'nama' => 'BENDAHARA',
            'level' => '3'
        ]);

        \DB::table('jabatan')->insert([
            'nama' => 'PENDAFTARAN',
            'level' => '4'
        ]);
        \DB::table('jabatan')->insert([
            'nama' => 'PENIMBANGAN',
            'level' => '4'
        ]);
        \DB::table('jabatan')->insert([
            'nama' => 'PENCATATAN',
            'level' => '4'
        ]);
        \DB::table('jabatan')->insert([
            'nama' => 'PENYULUHAN',
            'level' => '4'
        ]);
    }
}