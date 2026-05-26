<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ManagerAccountController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->as('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
        Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
        Route::get('/menu-items', [MenuItemController::class, 'index'])->name('menu-items.index');
        Route::post('/menu-items', [MenuItemController::class, 'store'])->name('menu-items.store');
        Route::redirect('/menu-items/create', '/admin/menu-items')->name('menu-items.create');
        Route::get('/menu-items/{menuItem}/edit', [MenuItemController::class, 'edit'])->name('menu-items.edit');
        Route::put('/menu-items/{menuItem}', [MenuItemController::class, 'update'])->name('menu-items.update');
        Route::delete('/menu-items/{menuItem}', [MenuItemController::class, 'destroy'])->name('menu-items.destroy');
        Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
        Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
        Route::get('/managers/create', [ManagerAccountController::class, 'create'])->name('managers.create');
        Route::post('/managers', [ManagerAccountController::class, 'store'])->name('managers.store');
        Route::get('/managers/{manager}/edit', [ManagerAccountController::class, 'edit'])->name('managers.edit');
        Route::put('/managers/{manager}', [ManagerAccountController::class, 'update'])->name('managers.update');
        Route::delete('/managers/{manager}', [ManagerAccountController::class, 'destroy'])->name('managers.destroy');
        Route::view('/deliveries', 'admin.deliveries.index')->name('deliveries.index');
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::get('/analytics', [SettingsController::class, 'analytics'])->name('analytics.index');
    });
