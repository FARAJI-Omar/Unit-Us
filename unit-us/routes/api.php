<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeEventController;
use App\Http\Controllers\EmployeeRewardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\WelcomeController;
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
        Route::get('/welcome', [WelcomeController::class, 'showWelcomeForm']);
        Route::post('/welcome', [WelcomeController::class, 'setPassword']);

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

                // Event Management
                Route::get('/admin/events', [EventController::class, 'index']);
                Route::post('/admin/events', [EventController::class, 'store']);
                Route::put('/admin/events/{eventId}', [EventController::class, 'update']);
                Route::delete('/admin/events/{eventId}', [EventController::class, 'destroy']);
                Route::post('/admin/events/{eventId}/attendance', [EventController::class, 'manageAttendance']);

                // Reward Management
                Route::get('/admin/rewards', [RewardController::class, 'index']);
                Route::post('/admin/rewards', [RewardController::class, 'store']);
                Route::put('/admin/rewards/{rewardId}', [RewardController::class, 'update']);
                Route::post('/admin/rewards/{rewardId}/toggle', [RewardController::class, 'toggleAvailability']);
                Route::get('/admin/redemptions', [RewardController::class, 'redemptionHistory']);

                // Point Management
                Route::post('/admin/adjustpoints/{profileId}', [PointController::class, 'adjust']);
            });

            // --- EMPLOYEE ROUTES ---
            // Events
            Route::get('/events/upcoming', [EmployeeEventController::class, 'upcoming']);
            Route::post('/events/{eventId}/register', [EmployeeEventController::class, 'register']);
            Route::get('/events/myevents', [EmployeeEventController::class, 'myEvents']);

            // Rewards
            Route::get('/rewards', [EmployeeRewardController::class, 'index']);
            Route::post('/rewards/{rewardId}/purchase', [EmployeeRewardController::class, 'purchase']);

            // Points history
            Route::get('/pointshistory', [EmployeeRewardController::class, 'history']);

            // Leaderboard
            Route::get('/leaderboard', [LeaderboardController::class, 'index']);
        });
    });