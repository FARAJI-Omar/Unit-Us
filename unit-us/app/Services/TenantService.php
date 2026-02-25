<?php

namespace App\Services;

use App\Exceptions\Custom\TenantCreationException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class TenantService
{
    public function switchToTenant(string $dbName): void
    {
        DB::purge('tenant');
        Config::set('database.connections.tenant.database', $dbName);
        DB::reconnect('tenant');
        DB::setDefaultConnection('tenant');
    }

    public function switchToCentral(): void
    {
        DB::purge('tenant');
        DB::setDefaultConnection('unitus_central_db');
    }

    public function createTenantDatabase(string $dbName): void
    {
        try {
            DB::statement("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");

            $this->switchToTenant($dbName);

            Artisan::call('migrate', [
                '--path' => 'database/migrations/tenant',
                '--database' => 'tenant',
                '--force' => true,
            ]);

            $this->switchToCentral();
        } catch (\Exception $e) {
            $this->switchToCentral();
            throw new TenantCreationException('Failed to create tenant database: ' . $e->getMessage());
        }
    }
}