<?php

namespace App\Observers;

use App\Models\Profile;
use App\Models\User;
use App\Services\TenantService;

class UserObserver
{
    public function __construct(private TenantService $tenantService)
    {
    }

    public function created(User $user): void
    {
        if ($user->entreprise_id) {
            $dbName = $user->entreprise->db_name;

            $this->tenantService->switchToTenant($dbName);

            Profile::create([
                'user_id' => $user->id,
                'fullname' => $user->name ?? 'User',
                'points_balance' => 0,
            ]);

            $this->tenantService->switchToCentral();
        }
    }

    public function updated(User $user): void
    {
        //
    }

    public function deleted(User $user): void
    {
        //
    }

    public function restored(User $user): void
    {
        //
    }

    public function forceDeleted(User $user): void
    {
        //
    }
}
