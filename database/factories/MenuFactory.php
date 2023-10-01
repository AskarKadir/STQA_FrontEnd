<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'         => $this->faker->text(5),
            'price'        => $this->faker->randomNumber(5),
            'image'        => $this->faker->imageUrl(),
            'description'  => $this->faker->text,
            'category'     => $this->faker->randomElement(['food', 'drink']),
            'is_available' => $this->faker->boolean(),
        ];
    }
}