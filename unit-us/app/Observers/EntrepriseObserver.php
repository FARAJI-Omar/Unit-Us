<?php

namespace App\Observers;

use App\Models\Entreprise;
use App\Services\TenantService;

class EntrepriseObserver
{
    public function __construct(private TenantService $tenantService)
    {
    }

    public function created(Entreprise $entreprise): void
    {
        $this->tenantService->createTenantDatabase($entreprise->db_name);
    }

    public function updated(Entreprise $entreprise): void
    {
        //
    }

    public function deleted(Entreprise $entreprise): void
    {
        //
    }

    public function restored(Entreprise $entreprise): void
    {
        //
    }

    public function forceDeleted(Entreprise $entreprise): void
    {
        //
    }
}
