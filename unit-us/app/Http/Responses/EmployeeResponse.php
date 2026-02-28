<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class EmployeeResponse
{
    public static function created(string $email): JsonResponse
    {
        return response()->json([
            'message' => 'Employee successfully invited to your tenant.',
            'email' => $email,
        ], 201);
    }

    public static function list(array $employees): JsonResponse
    {
        return response()->json(['data' => $employees]);
    }

    public static function single(array $employee): JsonResponse
    {
        return response()->json(['data' => $employee]);
    }

    public static function updated(array $employee): JsonResponse
    {
        return response()->json([
            'message' => 'Employee updated successfully.',
            'data' => $employee,
        ]);
    }

    public static function deleted(): JsonResponse
    {
        return response()->json(['message' => 'Employee deleted successfully.']);
    }
}
