<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EdukasiModel>
 */
class EdukasiModelFactory extends Factory
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
            'materi' => $this->faker->paragraph,
            'gambar' => '/images/upload/default.png',
        ];
    }
}
