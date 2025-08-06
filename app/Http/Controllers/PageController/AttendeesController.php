<?php

namespace App\Http\Controllers\PageController;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use Illuminate\Http\Request;

class AttendeesController extends BaseController
{
    public function index($id)
    {
        $event = $this->getEvent($id);
        $viewData = $this->getViewData('attendees', $event);
        $search = request('search');

        $attendeesQuery = Attendee::whereHas(
            'order.items.product',
            fn($q) =>
            $q->where('event_id', $event->id)
        )->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        });

        $attendees = $attendeesQuery
            ->orderByRaw("FIELD(status, 'used', 'active', 'pending')")
            ->latest()
            ->paginate(10);

        // Total per status (gunakan clone agar tidak merusak query utama)
        $usedCount = (clone $attendeesQuery)->where('status', 'used')->count();
        $activeCount = (clone $attendeesQuery)->where('status', 'active')->count();
        $pendingCount = (clone $attendeesQuery)->where('status', 'pending')->count();

        $totalAttendees = $usedCount + $activeCount + $pendingCount;

        return view('Admin.eventDashboard.index', array_merge($viewData, [
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
