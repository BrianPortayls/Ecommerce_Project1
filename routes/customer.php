<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'customer.home')->name('home');

Route::view('/menus', 'customer.menu')->name('menus');

Route::view('/dashboard', 'customer.dashboard')
    ->middleware(['auth', 'role:customer'])
    ->name('dashboard');
