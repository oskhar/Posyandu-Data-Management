<?php

namespace Database\Seeders;

use App\Models\GambarModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GambarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GambarModel::factory(10)->create();
    }
}
