<?php

namespace App\Services;

use App\Exceptions\Custom\InvalidCredentialsException;
use App\Exceptions\Custom\UnauthorizedTenantAccessException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function authenticate(string $email, string $password, ?int $entrepriseId = null): User
    {
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw new InvalidCredentialsException();
        }

        if ($entrepriseId && $user->entreprise_id !== $entrepriseId) {
            throw new UnauthorizedTenantAccessException();
        }

        return $user;
    }

    public function generateTokens(User $user): array
    {
        return [
            'access_token' => $user->createToken('access_token', ['access'])->plainTextToken,
            'refresh_token' => $user->createToken('refresh_token', ['refresh'])->plainTextToken,
        ];
    }

    public function generateAccessToken(User $user): string
    {
        return $user->createToken('access_token', ['access'])->plainTextToken;
    }

    public function revokeCurrentToken(User $user): void
    {
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
    }
}
