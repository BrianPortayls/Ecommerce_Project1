<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
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
            'user_id' => User::factory(),
            'order_number' => 'MC-'.fake()->unique()->numberBetween(1000, 9999),
            'total_price' => fake()->randomFloat(2, 120, 1200),
            'status' => fake()->randomElement([
                Order::STATUS_PENDING,
                Order::STATUS_PREPARING,
                Order::STATUS_READY,
                Order::STATUS_COMPLETED,
            ]),
            'fulfillment_method' => fake()->randomElement([
                Order::FULFILLMENT_DELIVERY,
                Order::FULFILLMENT_PICKUP,
            ]),
            'delivery_location' => fake()->randomElement(['Downtown', 'Northside', 'University', 'Riverside']),
        ];
    }
}
