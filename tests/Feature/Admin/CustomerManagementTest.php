<?php

use App\Models\Order;
use App\Models\User;

test('admins can manage customer records', function () {
    $admin = User::factory()->admin()->create();
    $customer = User::factory()->create([
        'name' => 'Original Customer',
        'email' => 'customer-record@example.com',
    ]);
    Order::factory()->create([
        'user_id' => $customer->id,
        'total_price' => 250,
    ]);

    $this->actingAs($admin)
        ->get(route('admin.customers.index', absolute: false))
        ->assertOk()
        ->assertSee('Customer management')
        ->assertSee('Original Customer')
        ->assertSee('250.00');

    $this->actingAs($admin)
        ->put(route('admin.customers.update', $customer, absolute: false), [
            'name' => 'Updated Customer',
            'email' => 'updated-customer@example.com',
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $this->assertDatabaseHas('users', [
        'id' => $customer->id,
        'name' => 'Updated Customer',
        'email' => 'updated-customer@example.com',
    ]);
});

test('admins can delete customer records', function () {
    $admin = User::factory()->admin()->create();
    $customer = User::factory()->create();

    $this->actingAs($admin)
        ->delete(route('admin.customers.destroy', $customer, absolute: false))
        ->assertRedirect();

    $this->assertDatabaseMissing('users', ['id' => $customer->id]);
});
