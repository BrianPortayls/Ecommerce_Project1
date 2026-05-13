<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('auth')
    ->prefix('settings')
    ->name('settings.')
    ->group(function () {
        Volt::route('profile', 'settings.profile')
            ->name('profile');

        Volt::route('password', 'settings.password')
            ->name('password');

        Volt::route('appearance', 'settings.appearance')
            ->name('appearance');
    });
