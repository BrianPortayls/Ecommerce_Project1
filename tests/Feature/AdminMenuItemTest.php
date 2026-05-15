<?php

use App\Models\MenuItem;
use App\Models\User;

test('admins can view menu items in the catalog', function () {
    $admin = User::factory()->admin()->create();
    $menuItem = MenuItem::factory()->create([
        'name' => 'Tapsilog Supreme',
        'category' => 'Silog Meals',
        'price' => 145,
    ]);

    $this->actingAs($admin)
        ->get(route('admin.menu-items.index', absolute: false))
        ->assertOk()
        ->assertSee('All menu items')
        ->assertSee('Add menu')
        ->assertSee($menuItem->name)
        ->assertSee($menuItem->category)
        ->assertSee('&#8369;145.00', false);
});

test('admins can add a menu item from the catalog page', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.menu-items.store', absolute: false), [
            'name' => 'Sizzling Sisig',
            'category' => 'Sizzling',
            'description' => 'Creamy sisig with garlic rice.',
            'price' => 165,
            'image_url' => 'https://example.com/sisig.jpg',
            'is_available' => '1',
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $this->assertDatabaseHas('menu_items', [
        'name' => 'Sizzling Sisig',
        'category' => 'Sizzling',
        'price' => 165,
        'is_available' => true,
    ]);
});
