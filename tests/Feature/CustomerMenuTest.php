<?php

use App\Models\MenuItem;

test('customer menu page displays available menu items from the database', function () {
    MenuItem::factory()->create([
        'name' => 'Admin Added Burger Steak',
        'category' => 'Sizzling',
        'description' => 'Burger steak with mushroom gravy and rice.',
        'price' => 149,
        'is_available' => true,
    ]);

    MenuItem::factory()->create([
        'name' => 'Hidden Test Meal',
        'is_available' => false,
    ]);

    $this->get(route('menus', absolute: false))
        ->assertOk()
        ->assertSee('Admin Added Burger Steak')
        ->assertSee('Burger steak with mushroom gravy and rice.')
        ->assertSee('&#8369;149.00', false)
        ->assertDontSee('Hidden Test Meal');
});

test('customer menu page filters meals by category', function () {
    MenuItem::factory()->create([
        'name' => 'Filter Test Sisig',
        'category' => 'Sizzling',
        'is_available' => true,
    ]);

    MenuItem::factory()->create([
        'name' => 'Filter Test Pancit',
        'category' => 'Pancit',
        'is_available' => true,
    ]);

    $this->get(route('menus', ['category' => 'Sizzling'], false))
        ->assertOk()
        ->assertSee('Filter Test Sisig')
        ->assertDontSee('Filter Test Pancit')
        ->assertSee('category=Sizzling', false);
});
