<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        \DB::table('admin')->insert([
            'id_jabatan' => 1,
            'email_admin' => 'aidil@gmail.com',
            'nama_lengkap' => 'aidil manaf',
            'password' => Hash::make('123456'),
        ]);
        \DB::table('admin')->insert([
            'id_jabatan' => 3,
            'email_admin' => 'oskhar@gmail.com',
            'nama_lengkap' => 'Muh Oskhar',
            'password' => Hash::make('123456'),
        ]);
        \DB::table('admin')->insert([
            'id_jabatan' => 2,
            'email_admin' => 'faried@gmail.com',
            'nama_lengkap' => 'Faried Riansyah',
            'password' => Hash::make('123456'),
        ]);
        \DB::table('admin')->insert([
            'id_jabatan' => 4,
            'email_admin' => 'fajar@gmail.com',
            'nama_lengkap' => 'Fajar Ganevi',
            'password' => Hash::make('123456'),
        ]);
        \DB::table('admin')->insert([
            'id_jabatan' => 5,
            'email_admin' => 'faiz@gmail.com',
            'nama_lengkap' => 'Faiz Riansyah Manaf',
            'password' => Hash::make('123456'),
        ]);

    }
}
