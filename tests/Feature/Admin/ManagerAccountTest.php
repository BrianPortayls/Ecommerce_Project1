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

test('admins can edit manager accounts', function () {
    $admin = User::factory()->admin()->create();
    $manager = User::factory()->manager()->create([
        'name' => 'Original Name',
        'email' => 'original@example.com',
    ]);

    $this->actingAs($admin)
        ->get("/admin/managers/{$manager->id}/edit")
        ->assertOk()
        ->assertSee('Edit manager account');

    $this->actingAs($admin)
        ->put("/admin/managers/{$manager->id}", [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'password' => null,
            'password_confirmation' => null,
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $this->assertDatabaseHas('users', [
        'id' => $manager->id,
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
    ]);
});

test('admins can delete manager accounts', function () {
    $admin = User::factory()->admin()->create();
    $manager = User::factory()->manager()->create([
        'name' => 'Manager to Delete',
        'email' => 'delete@example.com',
    ]);

    $managerId = $manager->id;

    $this->assertDatabaseHas('users', ['id' => $managerId]);

    $this->actingAs($admin)
        ->delete("/admin/managers/{$manager->id}")
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $this->assertDatabaseMissing('users', ['id' => $managerId]);
});
