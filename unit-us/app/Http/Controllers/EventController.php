<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManageAttendanceRequest;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Services\EventService;

class EventController extends Controller
{
    public function __construct(private EventService $eventService) {}

    public function index()
    {
        return response()->json($this->eventService->getAllEvents());
    }

    public function store(StoreEventRequest $request)
    {
        $event = $this->eventService->createEvent($request->validated());
        return response()->json($event, 201);
    }

    public function update(UpdateEventRequest $request, $slug, $eventId)
    {
        $event = Event::findOrFail($eventId);
        $updated = $this->eventService->updateEvent($event, $request->validated());
        return response()->json($updated);
    }

    public function destroy($slug, $eventId)
    {
        $event = Event::findOrFail($eventId);
        $this->eventService->deleteEvent($event);
        return response()->json(['message' => 'Event deleted'], 200);
    }

    public function manageAttendance(ManageAttendanceRequest $request, $slug, $eventId)
    {
        $event = Event::findOrFail($eventId);
        $participant = $this->eventService->markAttendance(
            $event,
            $request->validated()['profile_id'],
            $request->validated()['status']
        );
        return response()->json($participant);
    }
}
