<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TagModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tag' => $this->faker->unique()->word,
        ];
    }
}
