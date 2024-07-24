<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TantanganModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'judul' => $this->faker->unique()->sentence(3),
            'gambar' => $this->faker->optional()->imageUrl(),
            'deskripsi' => $this->faker->paragraph(),
            'overview' => $this->faker->text(),
            'tanggal_mulai' => $this->faker->date(),
            'tanggal_selesai' => $this->faker->date(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
