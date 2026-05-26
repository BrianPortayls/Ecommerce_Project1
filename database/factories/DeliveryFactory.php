<?php

namespace Database\Factories;

use App\Models\Delivery;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Delivery>
 */
class DeliveryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'status' => fake()->randomElement([
                Delivery::STATUS_PENDING,
                Delivery::STATUS_OUT_FOR_DELIVERY,
                Delivery::STATUS_DELIVERED,
            ]),
        ];
    }
}
