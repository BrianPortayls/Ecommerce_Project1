<?php

use App\Models\User;

test('guests are redirected from the feedback page to the login page', function () {
    $this->get('/feedback')
        ->assertRedirect('/login');
});

test('customers can visit the feedback page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('feedback', absolute: false))
        ->assertOk()
        ->assertSee('Feedback menu')
        ->assertSee('Food Quality')
        ->assertSee('Delivery Speed')
        ->assertSee('Payment Issues')
        ->assertSee('Satisfaction rating')
        ->assertSee('Excellent')
        ->assertSee('data-category="Food Quality"', false)
        ->assertSee('Tell us what happened with delivery or preparation time.')
        ->assertSee('id="message-counter"', false)
        ->assertSee('Sending...')
        ->assertSee('Type your feedback here...');
});

test('customers can submit feedback', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('feedback.store', absolute: false), [
            'category' => 'Food Quality',
            'rating' => 5,
            'message' => 'The meal was great and pickup was fast.',
        ])
        ->assertRedirect();

    $this->assertAuthenticatedAs($user);
});

test('successful feedback submission flashes a confirmation message', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('feedback.store', absolute: false), [
            'category' => 'Food Quality',
            'rating' => 5,
            'message' => 'The meal was great and pickup was fast.',
        ])
        ->assertSessionHas('status', 'Thanks for your feedback! Your comments help us improve Micaller.');
});

test('customers must select a feedback category before submitting', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->from(route('feedback', absolute: false))
        ->post(route('feedback.store', absolute: false), [
            'message' => 'The meal was great and pickup was fast.',
        ])
        ->assertRedirect(route('feedback', absolute: false))
        ->assertSessionHasErrors('category');
});

test('customers must select a satisfaction rating before submitting', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->from(route('feedback', absolute: false))
        ->post(route('feedback.store', absolute: false), [
            'category' => 'Food Quality',
            'message' => 'The meal was great and pickup was fast.',
        ])
        ->assertRedirect(route('feedback', absolute: false))
        ->assertSessionHasErrors('rating');
});

test('admin users can not visit the customer feedback page', function () {
    $user = User::factory()->admin()->create();

    $this->actingAs($user)
        ->get(route('feedback', absolute: false))
        ->assertRedirect(route('admin.dashboard', absolute: false));
});
