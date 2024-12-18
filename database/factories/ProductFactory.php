<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

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
    public function definition()
    {
        return [
            'title' => fake()->word(2),
            'description' => fake()->paragraph(2),
            'price' => fake()->randomFloat(2, 10, 1000),
            'quantity'=> fake()->numberBetween(1,20),
            'sku' => fake()->unique()->regexify('[A-Z0-9]{6}'),
            'category_id' => fake()->numberBetween(1,5)
        ];
    }
}
