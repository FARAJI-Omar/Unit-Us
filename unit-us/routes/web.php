<?php

use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::prefix('{slug}')
    ->middleware('tenant.identify')
    ->group(function () {
        Route::get('/welcome', [WelcomeController::class, 'showWelcomeForm']);
        Route::get('/success', function($slug) {
            return view('success', ['slug' => $slug]);
        })->name('success');
    });
