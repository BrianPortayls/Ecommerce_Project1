<?php

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;

test('admins can manage orders from database records', function () {
    $admin = User::factory()->admin()->create();
    $customer = User::factory()->create(['name' => 'Order Customer']);
    $order = Order::factory()->create([
        'user_id' => $customer->id,
        'order_number' => 'MC-2001',
        'status' => Order::STATUS_PENDING,
        'fulfillment_method' => Order::FULFILLMENT_DELIVERY,
        'delivery_location' => 'Downtown',
    ]);
    OrderItem::factory()->create([
        'order_id' => $order->id,
        'name' => 'Chicken Rice Bowl',
        'quantity' => 2,
    ]);

    $this->actingAs($admin)
        ->get(route('admin.orders.index', absolute: false))
        ->assertOk()
        ->assertSee('Order management')
        ->assertSee('MC-2001')
        ->assertSee('Order Customer')
        ->assertSee('Chicken Rice Bowl');

    $this->actingAs($admin)
        ->put(route('admin.orders.update', $order, absolute: false), [
            'status' => Order::STATUS_READY,
            'fulfillment_method' => Order::FULFILLMENT_PICKUP,
            'delivery_location' => null,
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $this->assertDatabaseHas('orders', [
        'id' => $order->id,
        'status' => Order::STATUS_READY,
        'fulfillment_method' => Order::FULFILLMENT_PICKUP,
    ]);
});

test('admins can delete orders', function () {
    $admin = User::factory()->admin()->create();
    $order = Order::factory()->create();

    $this->actingAs($admin)
        ->delete(route('admin.orders.destroy', $order, absolute: false))
        ->assertRedirect();

    $this->assertDatabaseMissing('orders', ['id' => $order->id]);
});
