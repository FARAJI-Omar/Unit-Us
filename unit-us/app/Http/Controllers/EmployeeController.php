<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Responses\EmployeeResponse;
use App\Services\EmployeeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct(private EmployeeService $employeeService){}

    public function index(Request $request)
    {
        $employees = $this->employeeService->getAll($request->user()->entreprise_id);

        return response()->json($employees);
    }

    public function store(StoreEmployeeRequest $request): JsonResponse
    {
        $user = $this->employeeService->invite(
            $request->validated(),
            $request->user()->entreprise_id,
            $request->route('slug')
        );

        return EmployeeResponse::created($user->email);
    }

    public function show(Request $request, string $slug, string $id): JsonResponse
    {
        $employee = $this->employeeService->getById((int)$id, $request->user()->entreprise_id);

        return EmployeeResponse::single($employee);
    }

    public function update(UpdateEmployeeRequest $request, string $slug, string $id): JsonResponse
    {
        $employee = $this->employeeService->update((int)$id, $request->validated(), $request->user()->entreprise_id);

        return EmployeeResponse::updated($employee);
    }

    public function destroy(Request $request, string $slug, string $id): JsonResponse
    {
        $this->employeeService->delete((int)$id, $request->user()->entreprise_id);

        return EmployeeResponse::deleted();
    }
}