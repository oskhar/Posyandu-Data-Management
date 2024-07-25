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
            'email_admin' => 'nenih@gmail.com',
            'nama_lengkap' => 'Nenih',
            'password' => Hash::make('123456'),
        ]);
        \DB::table('admin')->insert([
            'id_jabatan' => 2,
            'email_admin' => 'jasniroza@gmail.com',
            'nama_lengkap' => 'Jasni Roza',
            'password' => Hash::make('123456'),
        ]);
        \DB::table('admin')->insert([
            'id_jabatan' => 3,
            'email_admin' => 'saribanon@gmail.com',
            'nama_lengkap' => 'Saribanon',
            'password' => Hash::make('123456'),
        ]);
        \DB::table('admin')->insert([
            'id_jabatan' => 4,
            'email_admin' => 'hartinigmail.com',
            'nama_lengkap' => 'Hartini',
            'password' => Hash::make('123456'),
        ]);
        \DB::table('admin')->insert([
            'id_jabatan' => 5,
            'email_admin' => 'srisuhita@gmail.com',
            'nama_lengkap' => 'Sri Suhita',
            'password' => Hash::make('123456'),
        ]);
        \DB::table('admin')->insert([
            'id_jabatan' => 5,
            'email_admin' => 'nasmah@gmail.com',
            'nama_lengkap' => 'Nasmah',
            'password' => Hash::make('123456'),
        ]);
        \DB::table('admin')->insert([
            'id_jabatan' => 5,
            'email_admin' => 'sriwindiarti@gmail.com',
            'nama_lengkap' => 'Sri Windiarti',
            'password' => Hash::make('123456'),
        ]);

    }
}
