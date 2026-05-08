<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::view('/dashboard', 'dashboard')
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

require __DIR__.'/auth.php';
