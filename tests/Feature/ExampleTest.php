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
        ->assertSee('href="'.route('dashboard').'"', false)
        ->assertSee(route('feedback'))
        ->assertSee(route('settings.profile'))
        ->assertSee('Feedback')
        ->assertSee('aria-label="Open customer menu"', false)
        ->assertSee('Settings')
        ->assertSee('Log out')
        ->assertSee('Popular')
        ->assertSee('Deals')
        ->assertDontSee('class="btn btn-primary-action">Log out</button>', false)
        ->assertDontSee('>Dashboard</a>', false);
});
