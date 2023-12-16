<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BeritaModel>
 */
class BeritaModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_admin' => 1,
            'judul' => $this->faker->sentence,
            'deskripsi' => $this->faker->paragraph,
            'tanggal_pelaksanaan' => $this->faker->date,
            'gambar' => '/images/upload/default.png',
        ];
    }
}
