<?php

namespace App\Http\Controllers\SuperAdmin\Pages\Events;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminEventsSettingsController extends SuperAdminEventsBaseController
{
    public function index($eventId)
    {
        $events = Event::with(['user', 'location', 'organization'])
            ->findOrFail($eventId);

        $organization = Auth::user()->organization;


        $viewData = $this->getEventsViewData('settings', $eventId);

        return view('superAdmin.index', array_merge($viewData, [
            'events' => $events,
            'organization' => $organization,
        ]));
    }

}
