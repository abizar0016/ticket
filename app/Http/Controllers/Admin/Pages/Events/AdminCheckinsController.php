<?php

namespace App\Http\Controllers\Admin\Pages\Events;

use App\Models\Attendee;
use App\Models\Checkin;
use App\Models\Event;
use Carbon\Carbon;

class AdminCheckinsController extends AdminBaseController
{
    public function index($eventId)
    {
        $events = Event::with(['user', 'organization'])
            ->findOrFail($eventId);

        $viewData = $this->getEventsViewData('checkins', $eventId);

        $search = request('search');
        $status = request('status');
        $today = Carbon::today();

        // Base query
        $attendeesQuery = Attendee::whereHas('order.items.product', fn($q) =>
            $q->where('event_id', $events->id)
        )
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('ticket_code', 'like', "%$search%");
            });
        })
        ->with(['order', 'checkins'])
        ->select('attendees.*')
        ->selectRaw('(
            SELECT MAX(created_at)
            FROM checkins
            WHERE checkins.attendee_id = attendees.id
        ) as last_checkin_at')
        ->selectRaw('EXISTS (
            SELECT 1
            FROM checkins
            WHERE checkins.attendee_id = attendees.id
            AND DATE(checkins.created_at) = ?
        ) as checked_today', [$today])
        ->orderByRaw("FIELD(status, 'used', 'active', 'pending', 'expired')")
        ->orderByDesc('last_checkin_at');

        // Filter tab
        if ($status === 'checked') {
            $attendeesQuery->whereRaw('EXISTS (
                SELECT 1 FROM checkins
                WHERE checkins.attendee_id = attendees.id
                AND DATE(checkins.created_at) = ?
            )', [$today]);
        } elseif ($status === 'pending') {
            $attendeesQuery->whereRaw('NOT EXISTS (
                SELECT 1 FROM checkins
                WHERE checkins.attendee_id = attendees.id
                AND DATE(checkins.created_at) = ?
            )', [$today]);
        }

        $attendees = $attendeesQuery->paginate(8);

        // Statistik
        $totalAttendees = Attendee::whereHas('order.items.product', fn($q) =>
            $q->where('event_id', $events->id)
        )->count();

        $checkedInCount = Checkin::whereHas('attendee.order.items.product', fn($q) =>
            $q->where('event_id', $events->id)
        )
        ->distinct('attendee_id')
        ->count('attendee_id');

        $recentCheckIns = Checkin::with(['attendee'])
            ->whereHas('attendee.order.items.product', fn($q) =>
                $q->where('event_id', $events->id)
            )
            ->orderByDesc('created_at')
            ->take(5)
            ->get()
            ->map(fn($checkin) => (object) [
                'name' => $checkin->attendee->name,
                'checked_in_at' => $checkin->created_at
            ]);

        return view('pages.admins.index', array_merge($viewData, [
            'events' => $events,
            'attendees' => $attendees,
            'totalAttendees' => $totalAttendees,
            'checkedInCount' => $checkedInCount,
            'remainingCount' => $totalAttendees - $checkedInCount,
            'checkedInPercentage' => $totalAttendees > 0 ? round(($checkedInCount / $totalAttendees) * 100) : 0,
            'recentCheckIns' => $recentCheckIns
        ]));
    }
}
