<?php

namespace App\Http\Controllers\SuperAdmin\Events;

use App\Http\Controllers\SuperAdmin\SuperAdminBaseController;
use Illuminate\Support\Facades\Auth;

class SuperAdminEventsBaseController extends SuperAdminBaseController
{
    protected function getEventsViewData(string $eventsContent, int $id)
    {
        return [
            'activeContent' => 'events-content',
            'eventsContent' => $eventsContent,
            'eventId'       => $id,
            'user'          => Auth::user(),
        ];
    }
}

