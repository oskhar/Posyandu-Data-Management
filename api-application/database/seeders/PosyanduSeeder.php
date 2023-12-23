<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PosyanduSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        \DB::table('posyandu')->insert([
            'nama_posyandu' => 'Posyandu Melati',
            'kota' => 'Tangerang',
            'kecamatan' => 'Periuk',
            'kelurahan' => 'Periuk',
            'penyampaian_ketua' => 'Assalamu’alaikum Warahmatullahi Wabarakaatuh. Salam sejahtera untuk kita semua. Selamat datang di website Posyandu Melati. Website ini dibangun sebagai sarana atau media informasi dan komunikasi masyarakat, karena sejalan dengan perkembangan teknologi industri 4.0 yang berguna untuk memudahkan mencari informasi tentang POSYANDU MELATI.',
            'gambar_gedung' => '/images/upload/default.png',
            'visi' => 'Mewujudkan masyarakat yang sehat, sejahtera, dan berdaya melalui pelayanan kesehatan yang terpadu dan partisipatif di tingkat desa."',
            'misi' => '1.) Pelayanan Kesehatan Berkualitas:
            Menyelenggarakan pelayanan kesehatan yang berkualitas melalui kegiatan pengukuran status gizi, imunisasi, pemeriksaan kesehatan ibu dan anak, serta edukasi 
2.) Pemberdayaan Masyarakat:
            Meningkatkan pengetahuan dan keterampilan masyarakat dalam hal kesehatan, gizi, dan sanitasi melalui kegiatan pelatihan, sosialisasi, dan diskusi kelompok.
3.) Kerjasama dan Kemitraan:
            Membangun kerjasama yang erat dengan pihak-pihak terkait, termasuk puskesmas, instansi pemerintah, lembaga swadaya masyarakat, dan sektor-sektor terkait untuk mendukung pelaksanaan program Posyandu.
4.) Monitoring dan Evaluasi:
            Melakukan monitoring dan evaluasi secara berkala terhadap pelaksanaan kegiatan Posyandu untuk menilai efektivitas dan efisiensi pelayanan kesehatan yang diselenggarakan.
5.) Partisipasi Aktif Masyarakat:
            Mendorong partisipasi aktif masyarakat dalam pengambilan keputusan, pelaksanaan kegiatan, dan pemeliharaan keberlanjutan Posyandu sebagai sarana pelayanan kesehatan.
6.) Inovasi dan Penelitian:
            Mengembangkan inovasi dalam pelayanan kesehatan serta mendukung kegiatan penelitian yang bertujuan untuk meningkatkan kualitas layanan dan menciptakan solusi-solusi yang inovatif.
7.) Aksesibilitas Pelayanan:
            Menjamin aksesibilitas pelayanan kesehatan yang merata bagi seluruh lapisan masyarakat di wilayah desa, dengan memastikan bahwa Posyandu dapat dijangkau dengan mudah oleh seluruh penduduk.
8.) Keberlanjutan Program:
            Menyusun strategi keberlanjutan program Posyandu dengan melibatkan pihak-pihak terkait, serta menggalang dukungan dari masyarakat dan pemerintah setempat.',
            'rt_rw' => '01/001',
        ]);
    }
}
