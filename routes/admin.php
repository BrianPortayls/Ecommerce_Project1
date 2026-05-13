<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ManagerAccountController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->as('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');
        Route::get('/managers/create', [ManagerAccountController::class, 'create'])->name('managers.create');
        Route::post('/managers', [ManagerAccountController::class, 'store'])->name('managers.store');
    });
