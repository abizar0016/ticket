<?php

namespace App\Http\Controllers\Admin\Pages\Events;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminBaseController extends Controller
{
protected function getEventsViewData(string $eventsContent, int $id)
    {
        return [
            'eventsContent' => $eventsContent,
            'eventId'       => $id,
            'user'          => Auth::user(),
        ];
    }
}
