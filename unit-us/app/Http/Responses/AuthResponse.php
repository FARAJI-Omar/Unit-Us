<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class AuthResponse
{
    public static function tokens(array $tokens): JsonResponse
    {
        return response()->json($tokens);
    }

    public static function invalidCredentials(): JsonResponse
    {
        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    public static function invalidTokenType(): JsonResponse
    {
        return response()->json(['error' => 'Invalid token type. Refresh token required.'], 403);
    }

    public static function loggedOut(): JsonResponse
    {
        return response()->json(['message' => 'Logged out successfully']);
    }
}
