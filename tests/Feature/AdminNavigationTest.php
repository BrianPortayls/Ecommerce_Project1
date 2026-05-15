<?php

use App\Models\User;

test('admin sidebar links route to admin sections', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('admin.dashboard', absolute: false))
        ->assertOk()
        ->assertSee(route('admin.orders.index', absolute: false))
        ->assertSee(route('admin.menu-items.index', absolute: false))
        ->assertSee(route('admin.customers.index', absolute: false))
        ->assertSee(route('admin.managers.create', absolute: false))
        ->assertSee(route('admin.deliveries.index', absolute: false))
        ->assertSee(route('admin.settings.index', absolute: false))
        ->assertSee(route('admin.analytics.index', absolute: false))
        ->assertSee('Analytics')
        ->assertSee('View store');

    collect([
        'admin.orders.index' => 'Orders workspace',
        'admin.menu-items.index' => 'All menu items',
        'admin.customers.index' => 'Customers workspace',
        'admin.deliveries.index' => 'Deliveries workspace',
    ])->each(function (string $expectedText, string $routeName) use ($admin) {
        $this->actingAs($admin)
            ->get(route($routeName, absolute: false))
            ->assertOk()
            ->assertSee($expectedText);
    });
});

test('settings page does not render analytics content', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('admin.settings.index', absolute: false))
        ->assertOk()
        ->assertSee('Store settings')
        ->assertDontSee('Total orders');
});
