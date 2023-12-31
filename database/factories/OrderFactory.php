<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => rand(1, 10),
            'menu_id' => rand(1, 50),
            'jumlah'  => rand(1, 10),
            'total'   => $this->faker->randomNumber(5),
            'status'  => $this->faker->randomElement(['menunggu pembayaran', 'diproses', 'selesai', 'ditolak']),
        ];
    }


}