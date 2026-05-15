<?php

namespace Database\Factories;

use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MenuItem>
 */
class MenuItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'Tapsilog Express',
                'Porksilog Bistro',
                'Cornsilog Kitchen',
                'Chicken Rice Bowl',
                'Sizzling Pork Plate',
            ]),
            'category' => fake()->randomElement(['Silog Meals', 'Sizzling', 'Chicken', 'Pancit', 'Drinks']),
            'description' => fake()->sentence(10),
            'price' => fake()->randomFloat(2, 85, 250),
            'image_url' => fake()->imageUrl(640, 480, 'food', true),
            'is_available' => true,
            'sort_order' => fake()->numberBetween(1, 50),
        ];
    }
}
