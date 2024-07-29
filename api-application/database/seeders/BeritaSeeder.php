<?php

namespace Database\Seeders;

use App\Models\BeritaModel;
use DB;
use Illuminate\Database\Seeder;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // BeritaModel::factory(30)->create();
        {
            // Seeder untuk tabel berita
            $news = [
                [
                    'id_admin' => 1,
                    'judul' => 'Pendaftaran Posyandu',
                    'deskripsi' => 'Acara pendaftaran peserta baru posyandu. Pastikan membawa kartu identitas dan buku kesehatan anak.',
                    'gambar' => '/images/upload/pendaftaran.png',
                    'tanggal_pelaksanaan' => '2024-08-10',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id_admin' => 2,
                    'judul' => 'Penimbangan Balita',
                    'deskripsi' => 'Kegiatan penimbangan rutin untuk memantau perkembangan berat dan tinggi badan balita.',
                    'gambar' => '/images/upload/penimbangan.png',
                    'tanggal_pelaksanaan' => '2024-08-15',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id_admin' => 1,
                    'judul' => 'Penyuluhan Kesehatan',
                    'deskripsi' => 'Penyuluhan tentang pentingnya imunisasi dan pola makan sehat untuk balita.',
                    'gambar' => '/images/upload/penyuluhan.png',
                    'tanggal_pelaksanaan' => '2024-08-20',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            DB::table('berita')->insert($news);
        }
    }
}
