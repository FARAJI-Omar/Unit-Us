<?php

namespace App\Services;

use App\Exceptions\Custom\EmployeeNotFoundException;
use App\Models\User;
use App\Models\Profile;
use App\Notifications\WelcomeEmployeeNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmployeeService
{
    public function __construct(private TenantService $tenantService)
    {
    }

    public function invite(array $data, int $entrepriseId, string $slug): User
    {
        return DB::connection('unitus_central_db')->transaction(function () use ($data, $entrepriseId, $slug) {
            $tempPassword = Str::random(12);

            $user = User::withoutEvents(function () use ($data, $entrepriseId, $tempPassword) {
                return User::create([
                    'email' => $data['email'],
                    'fullname' => $data['fullname'],
                    'password' => Hash::make($tempPassword),
                    'role' => 'employee',
                    'entreprise_id' => $entrepriseId,
                ]);
            });

            $dbName = $user->entreprise->db_name;
            $this->tenantService->switchToTenant($dbName);

            Profile::create([
                'user_id' => $user->id,
                'fullname' => $data['fullname'],
                'points_balance' => 0,
            ]);

            $this->tenantService->switchToCentral();

            $user->notify(new WelcomeEmployeeNotification($tempPassword, $slug));

            return $user;
        });
    }

    public function getAll(int $entrepriseId)
    {
        return User::where('entreprise_id', $entrepriseId)
            ->where('role', 'employee')
            ->paginate(10)
            ->through(function ($user) {
                return [
                    'id' => $user->id,
                    'email' => $user->email,
                    'profile' => Profile::where('user_id', $user->id)->first(),
                ];
            });
    }

    public function getById(int $id, int $entrepriseId): array
    {
        $user = User::where('id', $id)
            ->where('entreprise_id', $entrepriseId)
            ->where('role', 'employee')
            ->first();

        if (!$user) {
            throw new EmployeeNotFoundException();
        }

        return [
            'id' => $user->id,
            'email' => $user->email,
            'profile' => Profile::where('user_id', $user->id)->first(),
        ];
    }

    public function update(int $id, array $data, int $entrepriseId): array
    {
        $user = User::where('id', $id)
            ->where('entreprise_id', $entrepriseId)
            ->where('role', 'employee')
            ->first();

        if (!$user) {
            throw new EmployeeNotFoundException();
        }

        if (isset($data['email'])) {
            $user->update(['email' => $data['email']]);
        }

        if (isset($data['fullname'])) {
            $profile = Profile::where('user_id', $user->id)->first();
            if ($profile) {
                $profile->update(['fullname' => $data['fullname']]);
            }
        }

        return [
            'id' => $user->fresh()->id,
            'email' => $user->fresh()->email,
            'profile' => Profile::where('user_id', $user->id)->first(),
        ];
    }

    public function delete(int $id, int $entrepriseId): void
    {
        $user = User::where('id', $id)
            ->where('entreprise_id', $entrepriseId)
            ->where('role', 'employee')
            ->first();

        if (!$user) {
            throw new EmployeeNotFoundException();
        }

        Profile::where('user_id', $user->id)->delete();
        $user->tokens()->delete();
        $user->delete();
    }
}
