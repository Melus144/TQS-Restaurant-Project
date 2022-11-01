<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quantity' => $this->faker->randomFloat(2),
            'expiration_date' => $this->faker->dateTimeBetween(now(), '+30 days')->format('Y-m-d H:i:s'),
            'expired' => false,
            'food_id' => 0
        ];
    }
}
