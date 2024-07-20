<?php

namespace Database\Seeders;

use App\Models\ProdukModel;
use App\Models\TagModel;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProdukSeeder extends Seeder
{
    public function run()
    {
        ProdukModel::factory(300)->create();
        TagModel::factory(50)->create();

        $faker = Faker::create();
        $produkIds = ProdukModel::all()->pluck('id')->toArray();
        $tagIds = TagModel::all()->pluck('id')->toArray();

        foreach ($produkIds as $produkId) {
            $tagsForThisProduk = $faker->randomElements($tagIds, $faker->numberBetween(1, 20));

            foreach ($tagsForThisProduk as $tagId) {
                \DB::table('produk_tag')->insert([
                    'produk_id' => $produkId,
                    'tag_id' => $tagId,
                ]);
            }
        }
    }
}
