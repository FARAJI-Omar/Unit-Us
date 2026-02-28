<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RefreshTokenRequest;
use App\Http\Responses\AuthResponse;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService){}

    public function login(LoginRequest $request): JsonResponse
    {
        $entrepriseId = $request->route('slug') 
            ? \App\Models\Entreprise::where('slug', $request->route('slug'))->value('id')
            : null;

        $user = $this->authService->authenticate($request->email, $request->password, $entrepriseId);
        $tokens = $this->authService->generateTokens($user);

        return AuthResponse::tokens($tokens);
    }

    public function refresh(RefreshTokenRequest $request): JsonResponse
    {
        $accessToken = $this->authService->generateAccessToken($request->user());

        return AuthResponse::tokens(['access_token' => $accessToken]);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->revokeCurrentToken($request->user());

        return AuthResponse::loggedOut();
    }
}