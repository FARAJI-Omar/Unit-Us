<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Profile;
use App\Services\EventService;
use Illuminate\Http\Request;

class EmployeeEventController extends Controller
{
    public function __construct(private EventService $eventService) {}

    public function upcoming()
    {
        return response()->json($this->eventService->getUpcomingEvents());
    }

    public function register(Request $request, $slug, $eventId)
    {
        $user = $request->user();
        
        if ($user->role !== 'employee') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $event = Event::findOrFail($eventId);
        $profile = Profile::where('user_id', $user->id)->first();
        
        if (!$profile) {
            return response()->json(['error' => 'Profile not found'], 404);
        }

        try {
            $participant = $this->eventService->registerForEvent($event, $profile->id);
            return response()->json($participant, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function myEvents(Request $request)
    {
        $user = $request->user();
        
        if ($user->role !== 'employee') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $profile = Profile::where('user_id', $user->id)->first();
        
        if (!$profile) {
            return response()->json(['error' => 'Profile not found'], 404);
        }
        
        return response()->json($this->eventService->getMyEvents($profile->id));
    }
}
