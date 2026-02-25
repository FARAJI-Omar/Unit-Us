<?php

namespace App\Http\Middleware;

use App\Exceptions\Custom\TenantNotFoundException;
use App\Exceptions\Custom\UnauthorizedTenantAccessException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\TenantService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TenantMiddleware
{
    public function __construct(private TenantService $tenantService)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $slug = $request->route('slug');

        if (!$slug) {
            return response()->json(['error' => 'Tenant slug missing in URL'], 400);
        }

        $entreprise = DB::connection('unitus_central_db')
            ->table('entreprises')
            ->where('slug', $slug)
            ->first();

        if (!$entreprise) {
            throw new TenantNotFoundException();
        }

        $user = Auth::guard('sanctum')->user();
        
        if ($user && $user->entreprise_id !== $entreprise->id) {
            throw new UnauthorizedTenantAccessException();
        }

        $this->tenantService->switchToTenant($entreprise->db_name);

        $response = $next($request);

        $this->tenantService->switchToCentral();

        return $response;
    }
}