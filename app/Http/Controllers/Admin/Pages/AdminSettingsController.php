<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSettingsController extends AdminBaseController
{
    public function index($id)
    {
        $events = Event::with('organization', 'location')
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $organization = Auth::user()->organization;


        $viewData = $this->getViewData('settings', $events);

        return view('Admin.eventDashboard.index', array_merge($viewData, [
            'events' => $events,
            'organization' => $organization,

        ]));
    }
}
