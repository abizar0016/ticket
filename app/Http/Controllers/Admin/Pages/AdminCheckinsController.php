<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use App\Models\Checkin;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminCheckinsController extends AdminBaseController
{
    public function index($id)
    {
        $event = $this->getEvent($id);
        $viewData = $this->getViewData('checkins', $event);
        $search = request('search');
        $status = request('status');
        $tz = $viewData['tz'];
        $today = Carbon::today($tz);

        $attendeesQuery = Attendee::whereHas('order.items.product', fn($q) => $q->where('event_id', $event->id))
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->orWhere('ticket_code', 'like', "%$search%");
                });
            })
            ->when($status === 'checked', fn($q) => $q->whereHas('checkins', fn($q2) => $q2->whereDate('created_at', $today)))
            ->when($status === 'pending', fn($q) => $q->whereDoesntHave('checkins', fn($q2) => $q2->whereDate('created_at', $today)));


        $attendees = $attendeesQuery
            ->with([
                'order',
                'checkins'
            ])
            ->select('attendees.*')
            ->selectRaw('(
    SELECT MAX(created_at)
    FROM checkins
    WHERE checkins.attendee_id = attendees.id
) as last_checkin_at')
            ->orderByRaw("FIELD(status, 'used', 'active', 'pending')")
            ->orderByDesc('last_checkin_at')
            ->paginate(8);

        $attendees->getCollection()->transform(function ($attendee) {
            if ($attendee->checkins->isNotEmpty()) {
                $attendee->status = 'used';
            }
            return $attendee;
        });

        $totalAttendees = Attendee::whereHas('order.items.product', fn($q) => $q->where('event_id', $event->id))->count();
        $checkedInCount = Checkin::whereHas('attendee.order.items.product', fn($q) => $q->where('event_id', $event->id))
            ->distinct('attendee_id')
            ->count('attendee_id');

        return view('Admin.eventDashboard.index', array_merge($viewData, [
            'attendees' => $attendees,
            'totalAttendees' => $totalAttendees,
            'checkedInCount' => $checkedInCount,
            'remainingCount' => $totalAttendees - $checkedInCount,
            'checkedInPercentage' => $totalAttendees > 0 ? round(($checkedInCount / $totalAttendees) * 100) : 0,
            'recentCheckIns' => Checkin::with(['attendee'])
                ->whereHas('attendee.order.items.product', fn($q) => $q->where('event_id', $event->id))
                ->orderByDesc('created_at')
                ->take(5)
                ->get()
                ->map(function ($checkin) use ($tz) {
                    return (object) [
                        'name' => $checkin->attendee->name,
                        'checked_in_at' => $checkin->created_at->setTimezone($tz)
                    ];
                })
        ]));
    }
}
