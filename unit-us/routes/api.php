<?php


use App\Http\Controllers\RegistrationController;

use Illuminate\Support\Facades\Route;


// GLOBAL REGISTRATION (No slug)
Route::post('/register', [RegistrationController::class, 'register']);

