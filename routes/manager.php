<?php

use App\Http\Controllers\Manager\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('manager')
    ->as('manager.')
    ->middleware(['auth', 'role:manager'])
    ->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');
    });
