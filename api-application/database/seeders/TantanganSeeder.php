<?php

namespace Database\Seeders;

use App\Models\TantanganModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TantanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TantanganModel::factory(8)->create();
    }
}
