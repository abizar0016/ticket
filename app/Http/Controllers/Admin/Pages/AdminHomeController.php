<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\Organization;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminHomeController extends Controller
{
    public function index(Request $request)
    {
        $tz = request()->cookie('user_timezone', config('app.timezone'));
        $now = Carbon::now($tz);

        $status = $request->route('status');
        $search = $request->query('search');

        if (!in_array($status, ['draft', 'ended', 'ongoing', 'upcoming'])) {
            $status = null;
        }

        $baseQuery = Event::where('user_id', Auth::id());

        if ($search) {
            $baseQuery->where('title', 'like', '%' . $search . '%');
        }

        $counts = $this->getEventCountsByStatus($baseQuery, $now);

        $events = $baseQuery
            ->when($status, function ($query) use ($status, $now) {
                $this->applyStatusFilter($query, $status, $now);
            })
            ->orderBy('start_date')
            ->paginate(6)
            ->withQueryString();

        $eventsCount = Event::where('user_id', Auth::id())->count();

        $organization = Auth::user()->organization;

        $attendeesCount = [];
        foreach ($events as $event) {
            $attendeesCount[$event->id] = $event->attendees()
                ->whereIn('status', ['active', 'used'])
                ->whereHas('order', function ($q) {
                    $q->where('status', 'paid');
                })
                ->count();
        }

        return view('Admin.index', [
            'events' => $events,
            'eventsCount' => $eventsCount,
            'currentFilter' => $status,
            'now' => $now,
            'tz' => $tz,
            'organization' => $organization,
            'ongoingCount' => $counts['ongoing'],
            'upcomingCount' => $counts['upcoming'],
            'endedCount' => $counts['ended'],
            'attendeesCount' => $attendeesCount,
        ]);
    }

    protected function getEventCountsByStatus($baseQuery, Carbon $now)
    {
        $cloneQuery = clone $baseQuery;

        return [
            'draft' => $cloneQuery->clone()->where('status', 'draft')->count(),
            'upcoming' => $cloneQuery->clone()
                ->where('status', 'published')
                ->where('start_date', '>', $now)
                ->count(),
            'ended' => $cloneQuery->clone()
                ->where('status', 'published')
                ->whereNotNull('end_date')
                ->where('end_date', '<', $now)
                ->count(),
            'ongoing' => $cloneQuery->clone()
                ->where('status', 'published')
                ->where(function ($q) use ($now) {
                    $q->where('start_date', '<=', $now)
                        ->where(function ($q2) use ($now) {
                            $q2->whereNull('end_date')
                                ->orWhere('end_date', '>=', $now);
                        });
                })
                ->count()
        ];
    }
    protected function applyStatusFilter($query, string $status, Carbon $now)
    {
        return match ($status) {
            'draft' => $query->where('status', 'draft'),

            'upcoming' => $query->where('status', 'published')
                ->where('start_date', '>', $now),

            'ended' => $query->where('status', 'published')
                ->whereNotNull('end_date')
                ->where('end_date', '<', $now),

            'ongoing' => $query->where('status', 'published')
                ->where(function ($q) use ($now) {
                        $q->where('start_date', '<=', $now)
                        ->where(function ($q2) use ($now) {
                            $q2->whereNull('end_date')
                            ->orWhere('end_date', '>=', $now);
                        });
                    }),

            default => $query
        };
    }
}
