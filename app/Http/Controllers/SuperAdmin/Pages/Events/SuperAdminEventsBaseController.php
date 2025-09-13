<?php

namespace App\Http\Controllers\SuperAdmin\Pages\Events;

use App\Http\Controllers\SuperAdmin\Pages\SuperAdminBaseController;
use Illuminate\Support\Facades\Auth;

class SuperAdminEventsBaseController extends SuperAdminBaseController
{
    protected function getEventsViewData(string $eventsContent, int $id)
    {
        return [
            'activeContent' => 'events',
            'eventsContent' => $eventsContent,
            'eventId'       => $id,
            'user'          => Auth::user(),
        ];
    }
}

