<?php

namespace App\Http\Controllers\SuperAdmin\Events;

use App\Models\Attendee;
use App\Models\Event;

class SuperAdminEventsAttendeesController extends SuperAdminEventsSettingsController
{
    public function index($eventId)
    {
        $events = Event::with(['user', 'organization'])
            ->findOrFail($eventId);

        $viewData = $this->getEventsViewData('attendees', $eventId);
        $search = request('search');

        $attendeesQuery = Attendee::whereHas('order.items.product', function ($q) use ($events) {
            $q->where('event_id', $events->id);
        })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('ticket_code', 'like', "%{$search}%");
                });
            });

        $attendees = $attendeesQuery
            ->orderByRaw("FIELD(status, 'used', 'active', 'pending')")
            ->latest()
            ->paginate(10);

        $usedCount = (clone $attendeesQuery)->where('status', 'used')->count();
        $activeCount = (clone $attendeesQuery)->where('status', 'active')->count();
        $pendingCount = (clone $attendeesQuery)->where('status', 'pending')->count();

        $totalAttendees = $usedCount + $activeCount + $pendingCount;

        return view('layouts.superAdmin.index', array_merge($viewData, [
            'events' => $events,
            'attendees' => $attendees,
            'totalAttendees' => $totalAttendees,
            'usedAttendees' => $usedCount,
            'activeAttendees' => $activeCount,
            'pendingAttendees' => $pendingCount,
            'usedPercentage' => $totalAttendees > 0 ? round(($usedCount / $totalAttendees) * 100) : 0,
            'activePercentage' => $totalAttendees > 0 ? round(($activeCount / $totalAttendees) * 100) : 0,
            'pendingPercentage' => $totalAttendees > 0 ? round(($pendingCount / $totalAttendees) * 100) : 0,
        ]));
    }
}
