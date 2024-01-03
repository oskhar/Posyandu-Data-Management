<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ListPelayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $itemHasil = [
            'HB-0 24 JAM',
            'Vitamin',
            'BCG',
            'POLIO 1',
            'POLIO 2',
            'POLIO 3',
            'POLIO 4',
            'DPT-HB-HiB 1',
            'DPT-HB-HiB 2',
            'DPT-HB-HiB 3',
            'DPT-HB-HiB 4',
            'Inactivated Pollo Vaccine (IPV)',
            'Campak Rubella',
        ];
        foreach ($itemHasil as $hasil) {
            DB::table('list_pelayanan')->insert([
                'nama' => $hasil,
                'type' => 'hasil'
            ]);
        }
        $itemHasil = [
            'VIT A I',
            'VIT A II',
            'DPT-HB-HiB Lanjutan',
            'Campak Rubella Lanjutan',
            'Makanan Tambahan',
            'ORALIT',
        ];
        foreach ($itemHasil as $hasil) {
            DB::table('list_pelayanan')->insert([
                'nama' => $hasil,
                'type' => 'pelayanan'
            ]);
        }
    }
}
