<?php

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;

test('guests are redirected away from the manager dashboard', function () {
    $this->get('/manager/dashboard')->assertRedirect('/login');
});

test('authenticated users can visit the manager dashboard', function () {
    $user = User::factory()->manager()->create();
    $customer = User::factory()->create(['name' => 'Queue Customer']);
    $order = Order::factory()->create([
        'user_id' => $customer->id,
        'order_number' => 'MC-3001',
        'status' => Order::STATUS_PENDING,
    ]);
    OrderItem::factory()->create([
        'order_id' => $order->id,
        'name' => 'Database Meal',
    ]);

    $this->actingAs($user)
        ->get('/manager/dashboard')
        ->assertOk()
        ->assertSee('Manager Dashboard')
        ->assertSee('Queue Customer')
        ->assertSee('Database Meal')
        ->assertSee(route('manager.dashboard', absolute: false))
        ->assertDontSee('href="'.route('admin.dashboard').'"', false);
});

test('managers can update active order status', function () {
    $manager = User::factory()->manager()->create();
    $order = Order::factory()->create(['status' => Order::STATUS_PENDING]);

    $this->actingAs($manager)
        ->put(route('manager.orders.status', $order, absolute: false), [
            'status' => Order::STATUS_PREPARING,
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $this->assertDatabaseHas('orders', [
        'id' => $order->id,
        'status' => Order::STATUS_PREPARING,
    ]);
});

test('customers can not visit the manager dashboard', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/manager/dashboard')
        ->assertRedirect(route('dashboard', absolute: false));
});
