<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Responses\RegistrationResponse;
use App\Services\AuthService;
use App\Services\RegistrationService;
use Illuminate\Http\JsonResponse;

class RegistrationController extends Controller
{
    public function __construct(
        private RegistrationService $registrationService,
        private AuthService $authService
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->registrationService->registerEnterprise($request->validated());

        $accessToken = $this->authService->generateAccessToken($result['user']);

        return RegistrationResponse::success($result['user'], $result['entreprise'], $accessToken);
    }
}