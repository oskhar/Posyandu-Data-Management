<?php

namespace Database\Seeders;

use App\Models\PenugasanModel;
use App\Models\SuratModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RefreshKaderGendongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        SuratModel::query()->delete();
        PenugasanModel::query()->delete();
    }
}
