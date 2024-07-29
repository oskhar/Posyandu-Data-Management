<?php

namespace Database\Seeders;

use App\Models\TantanganModel;
use DB;
use Illuminate\Database\Seeder;

class TantanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // TantanganModel::factory(8)->create();
        // Seeder untuk tabel tantangan
        $challenges = [
            [
                'judul' => 'Pembuatan Poster Kesehatan Posyandu',
                'gambar' => '/images/upload/Poster_Kesehatan.jpeg',
                'deskripsi' => 'Tatacara lomba: \n1. Poster harus berisi informasi kesehatan yang relevan dengan kegiatan posyandu.\n2. Peserta dapat menggunakan berbagai teknik desain (digital/manual).\n3. Poster harus orisinal dan belum pernah dipublikasikan.\n4. Sertakan nama dan nomor telepon peserta pada bagian belakang poster.\n5. Poster harus dikumpulkan paling lambat pada tanggal yang telah ditentukan.\n\nKriteria Penilaian:\n1. Kreativitas dan Orisinalitas\n2. Kesesuaian dengan Tema\n3. Kejelasan Informasi\n4. Kualitas Desain',
                'overview' => 'Tantangan ini mengajak masyarakat untuk berpartisipasi dalam lomba pembuatan poster kesehatan untuk posyandu. Poster yang dibuat harus memberikan informasi yang bermanfaat dan menarik tentang kesehatan untuk pengunjung posyandu.',
                'tanggal_mulai' => '2024-08-01',
                'tanggal_selesai' => '2024-08-31',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('tantangan')->insert($challenges);
    }
}
