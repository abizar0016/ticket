<?php

namespace App\Http\Controllers\SuperAdmin\Activity;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SuperAdmin\SuperAdminBaseController;
use App\Models\Activity;
use Illuminate\Http\Request;

class SuperAdminActivityController extends SuperAdminBaseController
{
    public function index(Request $request)
    {
        $viewData = $this->getViewData('activity');

        // Query
        $query = Activity::with('user')
            ->latest();

        // Optional filter
        if ($search = $request->get('search')) {
            $query->where('action', 'like', "%{$search}%")
                ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%"));
        }

        $activities = $query->paginate(10);

        return view('layouts.superAdmin.index', array_merge($viewData, [
            'activities' => $activities,
        ]));
    }
}
