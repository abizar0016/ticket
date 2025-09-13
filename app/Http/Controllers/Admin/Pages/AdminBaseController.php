<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminBaseController extends Controller
{
    protected function getEvent($id)
    {
        return Event::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();
    }

    protected function getViewData($activeContent, $event)
    {
        return [
            'activeContent' => $activeContent,
            'now' => Carbon::now(request()->cookie('user_timezone', config('app.timezone'))),
            'tz' => request()->cookie('user_timezone', config('app.timezone')),
            'user' => Auth::user(),
            'event' => $event,
            'organizations' => $organizations = Auth::user()->organization,
            'currentFilter' => request()->input('status'),
        ];
    }

    protected function applyStatusFilter($query, string $status, Carbon $now)
    {
        return match ($status) {
            'draft' => $query->where('status', 'draft'),
            'upcoming' => $query->where('status', 'published')->where('start_date', '>', $now),
            'ended' => $query->where('status', 'published')->whereNotNull('end_date')->where('end_date', '<', $now),
            'ongoing' => $query->where('status', 'published')
                ->where('start_date', '<=', $now)
                ->where(fn($q) => $q->whereNull('end_date')->orWhere('end_date', '>=', $now)),
            default => $query
        };
    }
}
