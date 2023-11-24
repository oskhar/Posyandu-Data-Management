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
            'password' => Hash::make('123456')
        ]);
    }
}
