<?php

namespace App\Http\Controllers\Admin\Pages\Events;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSettingsController extends AdminBaseController
{
    public function index($eventId)
    {
        $events = Event::with(['user', 'organization'])
            ->findOrFail($eventId);

        $organization = Auth::user()->organization;


        $viewData = $this->getEventsViewData('settings', $eventId);

        return view('pages.admins.index', array_merge($viewData, [
            'events' => $events,
            'organization' => $organization,

        ]));
    }
}
