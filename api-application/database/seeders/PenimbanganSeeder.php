<?php

namespace Database\Seeders;

use App\Models\PenimbanganModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenimbanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        PenimbanganModel::factory(100)->create();
    }
}
