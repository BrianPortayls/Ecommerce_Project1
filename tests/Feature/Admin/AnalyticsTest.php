<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;

test('admins can view analytics charts with dynamic store data', function () {
    $admin = User::factory()->admin()->create();
    $customer = User::factory()->create();

    DB::table('menu_items')->insert([
        [
            'name' => 'Tapsilog Express',
            'category' => 'Silog Meals',
            'description' => 'Breakfast favorite',
            'price' => 125,
            'image_url' => null,
            'is_available' => true,
            'sort_order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Chicken Rice Bowl',
            'category' => 'Chicken',
            'description' => 'Rice bowl',
            'price' => 145,
            'image_url' => null,
            'is_available' => true,
            'sort_order' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);

    $firstOrderId = DB::table('orders')->insertGetId([
        'user_id' => $customer->id,
        'total_price' => 18.50,
        'status' => 'completed',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $secondOrderId = DB::table('orders')->insertGetId([
        'user_id' => $customer->id,
        'total_price' => 24.00,
        'status' => 'completed',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    DB::table('deliveries')->insert([
        [
            'order_id' => $firstOrderId,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'order_id' => $secondOrderId,
            'status' => 'out_for_delivery',
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);

    DB::table('order_items')->insert([
        [
            'order_id' => $firstOrderId,
            'menu_item_id' => 1,
            'name' => 'Tapsilog Express',
            'category' => 'Silog Meals',
            'quantity' => 2,
            'unit_price' => 125,
            'line_total' => 250,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'order_id' => $secondOrderId,
            'menu_item_id' => 2,
            'name' => 'Chicken Rice Bowl',
            'category' => 'Chicken',
            'quantity' => 1,
            'unit_price' => 145,
            'line_total' => 145,
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);

    $this->actingAs($admin)
        ->get(route('admin.analytics.index', absolute: false))
        ->assertOk()
        ->assertSee('Store performance')
        ->assertSee('Total orders')
        ->assertSee('Weekly sales')
        ->assertSee('Meal mix')
        ->assertSee('Top selling meals')
        ->assertSee('weeklySalesChart')
        ->assertSee('mealMixChart')
        ->assertSee('topMealsChart')
        ->assertSee('Silog Meals')
        ->assertSee('Chicken')
        ->assertSee('Tapsilog Express')
        ->assertDontSee('Order status')
        ->assertDontSee('employeeChart');
});
