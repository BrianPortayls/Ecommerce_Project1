<?php

use App\Models\User;

test('guests are redirected away from the manager dashboard', function () {
    $this->get('/manager/dashboard')->assertRedirect('/login');
});

test('authenticated users can visit the manager dashboard', function () {
    $user = User::factory()->manager()->create();

    $this->actingAs($user)
        ->get('/manager/dashboard')
        ->assertOk()
        ->assertSee('Manager Dashboard')
        ->assertSee(route('manager.dashboard', absolute: false))
        ->assertDontSee(route('admin.dashboard', absolute: false));
});

test('customers can not visit the manager dashboard', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/manager/dashboard')
        ->assertRedirect(route('dashboard', absolute: false));
});
