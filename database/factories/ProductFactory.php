<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $price = $this->faker->randomFloat(2, 50, 1000);
        $rentalPrice = $this->faker->randomFloat(2, 5, $price * 0.1);

        return [
            'name' => $this->faker->words(3, true),
            'price' => $price,
            'rental_price' => $rentalPrice,
        ];
    }
}

