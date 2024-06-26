<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => \App\Models\Product::factory(),
            'user_id' => \App\Models\User::factory(),
            'transaction_date' => now(),
            'status' => $this->faker->randomElement(['purchased', 'gifted', 'serviced', 'donated', 'returned']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
