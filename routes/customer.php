<?php

use App\Http\Controllers\Customer\MenuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::view('/', 'customer.home')->name('home');

Route::get('/menus', MenuController::class)->name('menus');

Route::view('/dashboard', 'customer.dashboard')
    ->middleware(['auth', 'role:customer'])
    ->name('dashboard');

Route::view('/feedback', 'customer.feedback')
    ->middleware(['auth', 'role:customer'])
    ->name('feedback');

Route::post('/feedback', function (Request $request) {
    $request->validate([
        'category' => ['required', 'string', 'in:Food Quality,Delivery Speed,Packaging,Customer Service,App Experience,Payment Issues'],
        'rating' => ['required', 'integer', 'between:1,5'],
        'message' => ['required', 'string', 'max:1000'],
    ]);

    return back()->with('status', 'Thanks for your feedback! Your comments help us improve Micaller.');
})
    ->middleware(['auth', 'role:customer'])
    ->name('feedback.store');
