<?php

namespace Database\Seeders;

use App\Models\UserModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserModel::create([
            "nama" => "user",
            "email" => "user@gmail.com",
            "password" => Hash::make("123456"),
            "whatsapp" => "123456789",
        ]);
        UserModel::create([
            "nama" => "Oskhar",
            "email" => "oskhar@gmail.com",
            "password" => Hash::make("123456"),
            "whatsapp" => "123456789",
        ]);
        UserModel::create([
            "nama" => "Vallen",
            "email" => "vallen@gmail.com",
            "password" => Hash::make("123456"),
            "whatsapp" => "123456789",
        ]);
        UserModel::create([
            "nama" => "Faryth",
            "email" => "faryth@gmail.com",
            "password" => Hash::make("123456"),
            "whatsapp" => "123456789",
        ]);
    }
}
