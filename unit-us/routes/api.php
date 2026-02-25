<?php

use App\Http\Controllers\AuthController;

use App\Http\Controllers\RegistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// GLOBAL REGISTRATION (No slug)
Route::post('/register', [RegistrationController::class, 'register']);

// All routes are prefixed with /{slug} (e.g., /google/login)
// The 'tenant.identify' middleware swaps the DB to the correct tenant.
Route::prefix('{slug}')
    ->middleware('tenant.identify') 
    ->group(function () {

        // --- PUBLIC ROUTES ---
        Route::post('/login', [AuthController::class, 'login']);

        // --- PROTECTED ROUTES ---
        Route::middleware('auth:sanctum')->group(function () {
            
            Route::post('/refresh', [AuthController::class, 'refresh']);
            Route::post('/logout', [AuthController::class, 'logout']);

            Route::get('/me', function (Request $request) {
                return response()->json($request->user());
            });

            
        });
    });