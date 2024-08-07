<?php

namespace Database\Factories;

use App\Models\Supplier;
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
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text(20),
            'description' => fake()->text(30),
            'price' => fake()->randomFloat(2, 10, 1000),
            'quantity' => fake()->numberBetween(1, 100),
            'supplier_id' => Supplier::factory(),
        ];
    }
}
