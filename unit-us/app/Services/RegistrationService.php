<?php

namespace App\Services;

use App\Models\Entreprise;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegistrationService
{
    public function __construct(private TenantService $tenantService)
    {
    }

    public function registerEnterprise(array $data): array
    {
        $dbName = 'tenant_' . str_replace('-', '_', $data['slug']);

        return DB::connection('unitus_central_db')->transaction(function () use ($data, $dbName) {
            $entreprise = Entreprise::create([
                'name' => $data['entreprise_name'],
                'slug' => $data['slug'],
                'db_name' => $dbName,
            ]);

            $user = User::withoutEvents(function () use ($data, $entreprise) {
                return User::create([
                    'email' => $data['email'],
                    'fullname' => $data['fullname'],
                    'password' => Hash::make($data['password']),
                    'role' => 'admin',
                    'entreprise_id' => $entreprise->id,
                ]);
            });

            return [
                'user' => $user,
                'entreprise' => $entreprise,
            ];
        });
    }
}
