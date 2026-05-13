<?php

use App\Models\User;

test('admins can view the create manager account page', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/admin/managers/create')
        ->assertOk()
        ->assertSee('Create manager account')
        ->assertSee('Manager accounts');
});

test('customers can not view the create manager account page', function () {
    $customer = User::factory()->create();

    $this->actingAs($customer)
        ->get('/admin/managers/create')
        ->assertRedirect(route('dashboard', absolute: false));
});

test('admins can create manager accounts', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post('/admin/managers', [
            'name' => 'Store Manager',
            'email' => 'manager@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $this->assertDatabaseHas('users', [
        'name' => 'Store Manager',
        'email' => 'manager@example.com',
        'role' => User::ROLE_MANAGER,
    ]);
});
