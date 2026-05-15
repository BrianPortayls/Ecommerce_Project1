<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menuItems = [
            [
                'name' => 'Tapsilog',
                'category' => 'Silog Meals',
                'description' => 'Tender beef tapa with garlic rice, egg, and atsara.',
                'price' => 145,
                'image_url' => 'https://images.squarespace-cdn.com/content/v1/5a81c36ea803bb1dd7807778/1594846820039-AO7F8150VQUY1O1VPGT7/Tapsilog',
                'sort_order' => 1,
            ],
            [
                'name' => 'Cornsilog',
                'category' => 'Silog Meals',
                'description' => 'Corned beef, fried egg, and garlic rice for a classic comfort plate.',
                'price' => 120,
                'image_url' => 'https://lalunacafe.ph/wp-content/uploads/2022/08/corned-beef-silog-1-1.jpg',
                'sort_order' => 2,
            ],
            [
                'name' => 'Porksilog',
                'category' => 'Silog Meals',
                'description' => 'Crispy pork strips served with egg, garlic rice, and dipping sauce.',
                'price' => 135,
                'image_url' => 'https://www.bxtra.ph/images/thumbs/000/0004880_pork-silog.jpeg',
                'sort_order' => 3,
            ],
            [
                'name' => 'Sizzling Sisig',
                'category' => 'Sizzling',
                'description' => 'Creamy, savory sisig served sizzling with calamansi and chili.',
                'price' => 165,
                'image_url' => 'https://images.unsplash.com/photo-1625938144755-652e08e359b7?q=80&w=1200&auto=format&fit=crop',
                'sort_order' => 4,
            ],
            [
                'name' => 'Chicken Inasal',
                'category' => 'Chicken',
                'description' => 'Char-grilled chicken with java rice and chicken oil.',
                'price' => 155,
                'image_url' => 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?q=80&w=1200&auto=format&fit=crop',
                'sort_order' => 5,
            ],
            [
                'name' => 'Pancit Canton',
                'category' => 'Pancit',
                'description' => 'Stir-fried noodles with vegetables, pork, shrimp, and calamansi.',
                'price' => 130,
                'image_url' => 'https://images.unsplash.com/photo-1585032226651-759b368d7246?q=80&w=1200&auto=format&fit=crop',
                'sort_order' => 6,
            ],
        ];

        foreach ($menuItems as $menuItem) {
            MenuItem::updateOrCreate(
                ['name' => $menuItem['name']],
                $menuItem + ['is_available' => true]
            );
        }
    }
}
