<?php

use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;

test('guests are redirected away from the admin dashboard', function () {
    $this->get('/admin/dashboard')->assertRedirect('/login');
});

test('authenticated users can visit the admin dashboard', function () {
    $user = User::factory()->admin()->create();
    $customer = User::factory()->create(['name' => 'Maria Santos']);
    $menuItem = MenuItem::factory()->create([
        'name' => 'Tapsilog Express',
        'category' => 'Silog Meals',
        'price' => 145,
    ]);
    $order = Order::factory()->create([
        'user_id' => $customer->id,
        'order_number' => 'MC-1048',
        'total_price' => 290,
        'status' => Order::STATUS_PREPARING,
        'fulfillment_method' => Order::FULFILLMENT_DELIVERY,
        'delivery_location' => 'Downtown',
    ]);
    OrderItem::factory()->create([
        'order_id' => $order->id,
        'menu_item_id' => $menuItem->id,
        'name' => $menuItem->name,
        'category' => $menuItem->category,
        'quantity' => 2,
        'unit_price' => 145,
        'line_total' => 290,
    ]);

    $this->actingAs($user)
        ->get('/admin/dashboard')
        ->assertOk()
        ->assertSee('Food operations')
        ->assertSee('Micaller kitchen dashboard')
        ->assertSee('the kitchen is live')
        ->assertSee('Orders')
        ->assertSee('Menu items')
        ->assertSee('Recent food orders')
        ->assertSee('Meal mix')
        ->assertSee('Delivery zones')
        ->assertSee('Best performing meals')
        ->assertSee('Tapsilog Express')
        ->assertSee('Maria Santos')
        ->assertSee('css/admin/dashboard.css')
        ->assertDontSee('tas puro')
        ->assertDontSee('si gab lang');
});

test('customers can not visit the admin dashboard', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/admin/dashboard')
        ->assertRedirect(route('dashboard', absolute: false));
});
