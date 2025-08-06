<?php

namespace App\Http\Controllers\PageController;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends BaseController
{
public function index($id)
    {
        $event = Event::with('organizer', 'location')
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $viewData = $this->getViewData('settings', $event);

        return view('Admin.eventDashboard.index', array_merge($viewData, [
            'organizers' => Organizer::where('user_id', Auth::id())->get()
        ]));
    }
}
