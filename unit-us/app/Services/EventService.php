<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Profile;

class EventService
{
    public function __construct(private PointService $pointService) {}

    public function getAllEvents()
    {
        return Event::with('participants')->orderBy('date', 'desc')->paginate(10);
    }

    public function createEvent(array $data)
    {
        return Event::create($data);
    }

    public function updateEvent(Event $event, array $data)
    {
        $event->update($data);
        return $event;
    }

    public function deleteEvent(Event $event)
    {
        $event->delete();
    }

    public function markAttendance(Event $event, int $profileId, string $status)
    {
        $participant = EventParticipant::where('event_id', $event->id)
            ->where('profile_id', $profileId)
            ->firstOrFail();

        if ($status === 'attended' && $participant->status !== 'attended') {
            $profile = Profile::findOrFail($profileId);
            $this->pointService->addPoints(
                $profile,
                $event->points_reward,
                'earned',
                "Attended event: {$event->title}",
                $event
            );
        }

        $participant->update(['status' => $status]);
        return $participant;
    }

    public function getUpcomingEvents()
    {
        return Event::where('status', 'open')->paginate(10);
    }

    public function registerForEvent(Event $event, int $profileId)
    {
        if ($event->status !== 'open') {
            throw new \Exception('Event is not open for registration');
        }

        if ($event->isFull()) {
            throw new \Exception('Event is full');
        }

        $existing = EventParticipant::where('event_id', $event->id)
            ->where('profile_id', $profileId)
            ->first();

        if ($existing) {
            throw new \Exception('Already registered');
        }

        return EventParticipant::create([
            'event_id' => $event->id,
            'profile_id' => $profileId,
            'status' => 'registered',
        ]);
    }

    public function getMyEvents(int $profileId)
    {
        return EventParticipant::with('event')
            ->where('profile_id', $profileId)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }
}
