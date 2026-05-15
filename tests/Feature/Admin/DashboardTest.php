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
        ->assertSee('Food operations')
        ->assertSee('Micaller kitchen dashboard')
        ->assertSee('Hello Admin, lunch rush is warming up')
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
