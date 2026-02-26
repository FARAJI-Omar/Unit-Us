<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;

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

            // --- HR ADMIN ROUTES ---
            Route::middleware('can:manage-employees')->group(function () {
                // Employee Management
                Route::get('/admin/employees', [EmployeeController::class, 'index']);
                Route::post('/admin/employees', [EmployeeController::class, 'store']);
                Route::get('/admin/employees/{id}', [EmployeeController::class, 'show'])->where('id', '[0-9]+');
                Route::put('/admin/employees/{id}', [EmployeeController::class, 'update'])->where('id', '[0-9]+');
                Route::delete('/admin/employees/{id}', [EmployeeController::class, 'destroy'])->where('id', '[0-9]+');

                
            });

         
        });
    });