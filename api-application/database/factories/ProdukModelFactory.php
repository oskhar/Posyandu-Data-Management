<?php

namespace Database\Factories;

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
            'harga' => $this->faker->numberBetween(1000, 1000000),
            'gambar' => $this->faker->imageUrl(),
            'sedang_dijual' => $this->faker->boolean,
            'pin' => $this->faker->boolean,
        ];
    }
}
