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
        ->assertSee('admin-menu-action-button edit-button', false)
        ->assertSee('admin-menu-action-button delete-button', false)
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

test('admins can view the edit menu item page', function () {
    $admin = User::factory()->admin()->create();
    $menuItem = MenuItem::factory()->create();

    $this->actingAs($admin)
        ->get(route('admin.menu-items.edit', $menuItem, absolute: false))
        ->assertOk()
        ->assertSee('Edit menu item')
        ->assertSee('menu-edit-shell', false)
        ->assertSee('edit-menu-preview', false)
        ->assertSee('Update menu item details');
});

test('admins can update a menu item', function () {
    $admin = User::factory()->admin()->create();
    $menuItem = MenuItem::factory()->create([
        'name' => 'Original Name',
        'price' => 100,
    ]);

    $this->actingAs($admin)
        ->put(route('admin.menu-items.update', $menuItem, absolute: false), [
            'name' => 'Updated Name',
            'category' => $menuItem->category,
            'price' => 150,
            'image_url' => 'https://example.com/updated.jpg',
            'is_available' => '1',
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $this->assertDatabaseHas('menu_items', [
        'id' => $menuItem->id,
        'name' => 'Updated Name',
        'price' => 150,
    ]);
});

test('admins can delete a menu item', function () {
    $admin = User::factory()->admin()->create();
    $menuItem = MenuItem::factory()->create();

    $this->actingAs($admin)
        ->delete(route('admin.menu-items.destroy', $menuItem, absolute: false))
        ->assertRedirect(route('admin.menu-items.index'));

    $this->assertDatabaseMissing('menu_items', [
        'id' => $menuItem->id,
    ]);
});

test('admins can filter menu items by search', function () {
    $admin = User::factory()->admin()->create();
    $item1 = MenuItem::factory()->create(['name' => 'Tapsilog']);
    $item2 = MenuItem::factory()->create(['name' => 'Sizzling Sisig']);

    $this->actingAs($admin)
        ->get(route('admin.menu-items.index', ['search' => 'Tapsilo'], absolute: false))
        ->assertOk()
        ->assertSee('Tapsilog')
        ->assertDontSee('Sizzling Sisig');
});

test('admins can filter menu items by category', function () {
    $admin = User::factory()->admin()->create();
    $item1 = MenuItem::factory()->create(['category' => 'Silog Meals']);
    $item2 = MenuItem::factory()->create(['category' => 'Sizzling']);

    $this->actingAs($admin)
        ->get(route('admin.menu-items.index', ['category' => 'Silog Meals'], absolute: false))
        ->assertOk()
        ->assertSee('Silog Meals');
});

test('admins can filter menu items by availability', function () {
    $admin = User::factory()->admin()->create();
    $available = MenuItem::factory()->create(['is_available' => true, 'name' => 'Available Item']);
    $unavailable = MenuItem::factory()->create(['is_available' => false, 'name' => 'Unavailable Item']);

    $response = $this->actingAs($admin)
        ->get(route('admin.menu-items.index', ['availability' => '1'], absolute: false))
        ->assertOk();

    $response->assertSee('Available Item')
        ->assertDontSee('Unavailable Item');
});

test('admins can apply multiple filters at once', function () {
    $admin = User::factory()->admin()->create();
    $matching = MenuItem::factory()->create([
        'name' => 'Tapsilog',
        'category' => 'Silog Meals',
        'is_available' => true,
    ]);
    $notMatching = MenuItem::factory()->create([
        'name' => 'Sizzling Sisig',
        'category' => 'Sizzling',
        'is_available' => true,
    ]);

    $this->actingAs($admin)
        ->get(route('admin.menu-items.index', [
            'search' => 'Tapsilo',
            'category' => 'Silog Meals',
            'availability' => '1',
        ], absolute: false))
        ->assertOk()
        ->assertSee('Tapsilog');
});
