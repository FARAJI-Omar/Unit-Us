<?php

namespace App\Http\Responses;

use App\Models\Event;
use Illuminate\Http\JsonResponse;

class EventResponse
{
    public static function created(Event $event): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Event created successfully in the tenant database.',
            'data' => $event,
        ], 201);
    }
}
