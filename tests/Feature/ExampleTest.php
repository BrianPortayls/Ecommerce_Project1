<?php

use App\Models\User;

test('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Order Now');
});

test('customer home navigation shows feedback link', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('home', absolute: false))
        ->assertOk()
        ->assertSee(route('feedback', absolute: false))
        ->assertSee('Feedback');
});
