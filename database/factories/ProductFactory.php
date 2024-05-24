<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws \Random\RandomException
     */
    public function definition(): array
    {
        return [
            'name'      => $this->faker->word,
            'price'     => random_int(1, 9) * 10000,
            'inventory' => random_int(0, 100)
        ];
    }
}
