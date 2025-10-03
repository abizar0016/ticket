<?php

namespace App\Http\Controllers\SuperAdmin\Events;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminEventsSettingsController extends SuperAdminEventsBaseController
{
    public function index($eventId)
    {
        $events = Event::with(['user', 'organization'])
            ->findOrFail($eventId);

        $organization = Auth::user()->organization;


        $viewData = $this->getEventsViewData('settings', $eventId);

        return view('layouts.superAdmin.index', array_merge($viewData, [
            'events' => $events,
            'organization' => $organization,
        ]));
    }

    public function update(Request $request, $eventId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

}
}