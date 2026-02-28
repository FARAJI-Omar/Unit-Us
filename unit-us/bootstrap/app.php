<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
                'tenant.identify' => \App\Http\Middleware\TenantMiddleware::class,
            ]);
        $middleware->redirectGuestsTo(fn () => throw new \Illuminate\Auth\AuthenticationException());
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\App\Exceptions\Custom\TenantNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        });

        $exceptions->render(function (\App\Exceptions\Custom\UnauthorizedTenantAccessException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        });

        $exceptions->render(function (\App\Exceptions\Custom\TenantCreationException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        });

        $exceptions->render(function (\App\Exceptions\Custom\InvalidCredentialsException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        });

        $exceptions->render(function (\App\Exceptions\Custom\EmployeeNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        });
       
        $exceptions->render(function (\App\Exceptions\Custom\InsufficientBalanceException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        });

        $exceptions->render(function (\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => 'Database error occurred'], 500);
        });

        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }
            return response()->json(['error' => 'Unauthenticated'], 401);
        });

        $exceptions->render(function (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'errors' => $e->errors()], 422);
        });

        // This catches findOrFail failures AND invalid route URLs
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            return response()->json([
                'status'  => 'error',
                'message' => 'The requested resource was not found.'
            ], 404);
        });
    })->create();
