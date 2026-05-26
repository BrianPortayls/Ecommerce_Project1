<?php

namespace Database\Factories;

use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 4);
        $unitPrice = fake()->randomFloat(2, 85, 250);

        return [
            'order_id' => Order::factory(),
            'menu_item_id' => MenuItem::factory(),
            'name' => fake()->randomElement(['Tapsilog Express', 'Porksilog Bistro', 'Chicken Rice Bowl']),
            'category' => fake()->randomElement(['Silog Meals', 'Sizzling', 'Chicken', 'Drinks']),
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'line_total' => $unitPrice * $quantity,
        ];
    }
}
