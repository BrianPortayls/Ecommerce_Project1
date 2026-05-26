<?php

use App\Http\Controllers\Manager\DashboardController;
use App\Http\Controllers\Manager\MenuItemController;
use App\Http\Controllers\Manager\OrderStatusController;
use Illuminate\Support\Facades\Route;

Route::prefix('manager')
    ->as('manager.')
    ->middleware(['auth', 'role:manager'])
    ->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');
        Route::put('/orders/{order}/status', OrderStatusController::class)->name('orders.status');

        Route::get('/menu-items', [MenuItemController::class, 'index'])->name('menu-items.index');
        Route::get('/menu-items/{menuItem}/edit', [MenuItemController::class, 'edit'])->name('menu-items.edit');
        Route::put('/menu-items/{menuItem}', [MenuItemController::class, 'update'])->name('menu-items.update');
    });
