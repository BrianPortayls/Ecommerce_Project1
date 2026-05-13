<?php

use App\Models\User;

test('guests are redirected away from the admin dashboard', function () {
    $this->get('/admin/dashboard')->assertRedirect('/login');
});

test('authenticated users can visit the admin dashboard', function () {
    $user = User::factory()->admin()->create();

    $this->actingAs($user)
        ->get('/admin/dashboard')
        ->assertOk()
        ->assertSee('Admin dashboard')
        ->assertSee("Manage today's food orders", false)
        ->assertSee('Orders')
        ->assertSee('Menu items')
        ->assertSee('Add menu item')
        ->assertSee('Recent orders')
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
