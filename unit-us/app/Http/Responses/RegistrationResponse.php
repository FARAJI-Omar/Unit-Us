<?php

namespace App\Http\Responses;

use App\Models\User;
use App\Models\Entreprise;
use Illuminate\Http\JsonResponse;

class RegistrationResponse
{
    public static function success(User $user, Entreprise $entreprise, string $accessToken): JsonResponse
    {
        return response()->json([
            'message' => 'Enterprise and Tenant Database created successfully.',
            'user' => $user,
            'entreprise' => $entreprise,
            'access_token' => $accessToken,
        ], 201);
    }
}
