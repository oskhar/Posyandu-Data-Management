<?php

namespace Database\Seeders;

use App\Models\FormatAModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormatASeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        FormatAModel::factory(57977)->create();
    }
}
