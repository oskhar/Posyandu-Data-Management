<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ProdukSeeder extends Seeder
{
    public function run()
    {
        // ProdukModel::factory(300)->create();
        // TagModel::factory(25)->create();

        // $faker = Faker::create();
        // $produkIds = ProdukModel::all()->pluck('id')->toArray();
        // $tagIds = TagModel::all()->pluck('id')->toArray();

        // foreach ($produkIds as $produkId) {
        //     $tagsForThisProduk = $faker->randomElements($tagIds, $faker->numberBetween(1, 8));

        //     foreach ($tagsForThisProduk as $tagId) {
        //         \DB::table('produk_tag')->insert([
        //             'produk_id' => $produkId,
        //             'tag_id' => $tagId,
        //         ]);
        //     }
        // }use Illuminate\Database\Seeder;
        // Seeder untuk tabel admin

        // Seeder untuk tabel produk
        $products = [
            [
                'admin_id' => 1,
                'nomor_telepon' => '6281386380481',
                'nama' => 'Kunyit Asem',
                'deskripsi' => 'Minuman kesehatan dari kunyit dan asem',
                'overview' => 'Rasakan kesegaran dan manfaat kesehatan kunyit asem',
                'harga' => 15000,
                'gambar' => '/images/upload/Kunyit_Asem.jpeg',
                'sedang_dijual' => true,
                'pin' => false,
            ],
            [
                'admin_id' => 1,
                'nomor_telepon' => '6281386380481',
                'nama' => 'Keripik Brownies',
                'deskripsi' => 'Keripik brownies yang renyah dan manis',
                'overview' => 'Nikmati sensasi keripik brownies dalam setiap gigitan',
                'harga' => 25000,
                'gambar' => '/images/upload/Keripik_Brownies.jpeg',
                'sedang_dijual' => true,
                'pin' => false,
            ],
            [
                'admin_id' => 2,
                'nomor_telepon' => '6281386380481',
                'nama' => 'Keripik Singkong',
                'deskripsi' => 'Keripik singkong yang renyah dan gurih',
                'overview' => 'Camilan favorit keluarga, keripik singkong gurih',
                'harga' => 10000,
                'gambar' => '/images/upload/Keripik_Singkong.jpeg',
                'sedang_dijual' => true,
                'pin' => false,
            ],
            [
                'admin_id' => 2,
                'nomor_telepon' => '6281386380481',
                'nama' => 'Kopi Bengkulu',
                'deskripsi' => 'Kopi khas Bengkulu dengan cita rasa kuat',
                'overview' => 'Kopi Bengkulu, nikmati setiap seduhannya',
                'harga' => 50000,
                'gambar' => '/images/upload/Kopi_Bengkulu.jpeg',
                'sedang_dijual' => true,
                'pin' => false,
            ],
            [
                'admin_id' => 1,
                'nomor_telepon' => '6281386380481',
                'nama' => 'Peyek',
                'deskripsi' => 'Peyek kacang renyah dan gurih',
                'overview' => 'Peyek kacang yang nikmat untuk camilan',
                'harga' => 15000,
                'gambar' => '/images/upload/Peyek.jpeg',
                'sedang_dijual' => true,
                'pin' => false,
            ],
            [
                'admin_id' => 1,
                'nomor_telepon' => '6281386380481',
                'nama' => 'Syaal Brownzie',
                'deskripsi' => 'Syal hangat dan nyaman',
                'overview' => 'Syal Brownzie, pilihan tepat untuk musim dingin',
                'harga' => 30000,
                'gambar' => '/images/upload/Syaal_Brownzie.jpeg',
                'sedang_dijual' => true,
                'pin' => false,
            ],
            [
                'admin_id' => 2,
                'nomor_telepon' => '6281386380481',
                'nama' => 'Peyek Kacang Tanah',
                'deskripsi' => 'Peyek kacang tanah renyah dan gurih',
                'overview' => 'Peyek kacang tanah, camilan favorit keluarga',
                'harga' => 17000,
                'gambar' => '/images/upload/Peyek_Kacang_Tanah.jpeg',
                'sedang_dijual' => true,
                'pin' => false,
            ],
            [
                'admin_id' => 2,
                'nomor_telepon' => '6281386380481',
                'nama' => 'Sirup Jahe Merah',
                'deskripsi' => 'Sirup jahe merah dengan khasiat kesehatan',
                'overview' => 'Nikmati hangatnya sirup jahe merah',
                'harga' => 20000,
                'gambar' => '/images/upload/Sirup_Jahe_Merah.jpeg',
                'sedang_dijual' => true,
                'pin' => false,
            ],
        ];

        DB::table('produk')->insert($products);

        // Seeder untuk tabel tag dengan lebih banyak tag
        $tags = [
            ['tag' => 'Minuman'],
            ['tag' => 'Camilan'],
            ['tag' => 'Kopi'],
            ['tag' => 'Syal'],
            ['tag' => 'Herbal'],
            ['tag' => 'Manis'],
            ['tag' => 'Gurih'],
            ['tag' => 'Hangat'],
            ['tag' => 'Renya'],
            ['tag' => 'Sehat'],
        ];

        DB::table('tag')->insert($tags);

        // Seeder untuk tabel produk_tag dengan kombinasi tag yang lebih banyak
        $produkTags = [
            ['produk_id' => 1, 'tag_id' => 1], // Kunyit Asem - Minuman
            ['produk_id' => 1, 'tag_id' => 5], // Kunyit Asem - Herbal
            ['produk_id' => 1, 'tag_id' => 10], // Kunyit Asem - Sehat
            ['produk_id' => 2, 'tag_id' => 2], // Keripik Brownies - Camilan
            ['produk_id' => 2, 'tag_id' => 6], // Keripik Brownies - Manis
            ['produk_id' => 3, 'tag_id' => 2], // Keripik Singkong - Camilan
            ['produk_id' => 3, 'tag_id' => 7], // Keripik Singkong - Gurih
            ['produk_id' => 4, 'tag_id' => 3], // Kopi Bengkulu - Kopi
            ['produk_id' => 4, 'tag_id' => 8], // Kopi Bengkulu - Hangat
            ['produk_id' => 5, 'tag_id' => 2], // Peyek - Camilan
            ['produk_id' => 5, 'tag_id' => 7], // Peyek - Gurih
            ['produk_id' => 5, 'tag_id' => 9], // Peyek - Renyah
            ['produk_id' => 6, 'tag_id' => 4], // Syaal Brownzie - Syal
            ['produk_id' => 7, 'tag_id' => 2], // Peyek Kacang Tanah - Camilan
            ['produk_id' => 7, 'tag_id' => 7], // Peyek Kacang Tanah - Gurih
            ['produk_id' => 8, 'tag_id' => 1], // Sirup Jahe Merah - Minuman
            ['produk_id' => 8, 'tag_id' => 5], // Sirup Jahe Merah - Herbal
            ['produk_id' => 8, 'tag_id' => 8], // Sirup Jahe Merah - Hangat
            ['produk_id' => 8, 'tag_id' => 10], // Sirup Jahe Merah - Sehat
        ];

        DB::table('produk_tag')->insert($produkTags);
    }
}
