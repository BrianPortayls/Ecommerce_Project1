<?php

use App\Models\MenuItem;
use Livewire\Livewire;

test('store menu catalog is rendered as a live polling component', function () {
    MenuItem::factory()->create([
        'name' => 'Live Tapsilog',
        'category' => 'Silog Meals',
        'price' => 145,
        'is_available' => true,
    ]);

    $this->get(route('menus', absolute: false))
        ->assertOk()
        ->assertSee('wire:poll.3s', false)
        ->assertSee('Live Tapsilog');
});

test('live store catalog reflects menu changes on refresh cycle', function () {
    $menuItem = MenuItem::factory()->create([
        'name' => 'Original Sisig',
        'category' => 'Sizzling',
        'is_available' => true,
    ]);

    $component = Livewire::test('customer.live-menu-catalog')
        ->assertSee('Original Sisig');

    $menuItem->update(['name' => 'Updated Sisig']);

    $component
        ->call('$refresh')
        ->assertSee('Updated Sisig')
        ->assertDontSee('Original Sisig');
});
