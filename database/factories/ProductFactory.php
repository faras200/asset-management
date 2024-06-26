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
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'category' => $this->faker->word,
            'serial_number' => $this->faker->unique()->bothify('SN-#####'),
            'purchase_date' => $this->faker->date(),
            'price' => $this->faker->randomFloat(2, 100, 10000),
            'status' => $this->faker->randomElement(['available', 'in_use', 'in_service', 'donated', 'returned']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
