<?php

namespace App\Http\Controllers\SuperAdmin\Pages;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class SuperAdminAllEventsController extends SuperAdminBaseController
{
    public function index() {
        $viewData = $this->getViewData('allEvents');
        $events = Event::with('user', 'location', 'organization')
            ->latest()
            ->paginate(10);

        return view('superAdmin.index', array_merge($viewData, [
            'events' => $events,
        ]));
    }

}
