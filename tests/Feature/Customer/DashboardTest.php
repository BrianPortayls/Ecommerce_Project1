<?php

use App\Models\User;

test('guests are redirected to the login page', function () {
    $response = $this->get('/dashboard');
    $response->assertRedirect('/login');
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/dashboard');
    $response->assertStatus(200);
});

test('admin users can not visit the customer dashboard', function () {
    $user = User::factory()->admin()->create();

    $this->actingAs($user)
        ->get('/dashboard')
        ->assertRedirect(route('admin.dashboard', absolute: false));
});

test('manager users are redirected away from the customer dashboard', function () {
    $user = User::factory()->manager()->create();

    $this->actingAs($user)
        ->get('/dashboard')
        ->assertRedirect(route('manager.dashboard', absolute: false));
});
