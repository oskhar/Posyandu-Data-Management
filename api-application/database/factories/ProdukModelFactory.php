<?php

namespace Database\Factories;

use App\Models\ProdukModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProdukModel>
 */
class ProdukModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'admin_id' => 2,
            'nomor_telepon' => $this->faker->unique()->phoneNumber,
            'nama' => 'Produk ' . $this->faker->unique()->numberBetween(1, 100000),
            'deskripsi' => $this->faker->paragraph,
            'overview' => $this->faker->text,
            'harga' => $this->faker->numberBetween(1, 10000) * 1000,
            'gambar' => $this->faker->imageUrl(),
            'sedang_dijual' => $this->faker->boolean,
            'pin' => false,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (ProdukModel $produk) {
            // Menghitung jumlah produk yang sudah memiliki pin true
            $pinCount = ProdukModel::where('pin', true)->count();

            // Jika jumlah pin kurang dari 5, set pin true untuk produk ini
            if ($pinCount < 5) {
                $produk->pin = true;
                $produk->save();
            }
        });
    }
}
