<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->paragraph(4),
            'price' => $this->faker->numberBetween(100000, 2000000),
            'location' => $this->faker->city() . ', ' . $this->faker->stateAbbr(),
            'type' => $this->faker->randomElement(['sale', 'rent']),
            'is_featured' => $this->faker->boolean(25), // 25% chance of being featured
        ];
    }
}
