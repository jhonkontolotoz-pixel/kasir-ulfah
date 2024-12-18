<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
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
    public function definition()
    {
        return [
            'status' => fake()->randomElement(['pending','shipped','delivered']),
            'total_price' => $this->faker->randomFloat(2, 10, 1000),
            'payment_method' => $this->faker->randomElement(['cash', 'card']),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'customer_id' => Customer::inRandomOrder()->first()->id ?? Customer::factory(),

        ];
    }
}
