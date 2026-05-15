<?php

use App\Http\Controllers\Customer\MenuController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'customer.home')->name('home');

Route::get('/menus', MenuController::class)->name('menus');

Route::view('/dashboard', 'customer.dashboard')
    ->middleware(['auth', 'role:customer'])
    ->name('dashboard');
