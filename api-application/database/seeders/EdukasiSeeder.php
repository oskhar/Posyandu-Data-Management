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
        EdukasiModel::factory(57977)->create();
    }
}
