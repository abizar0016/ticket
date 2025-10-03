<?php

namespace App\Http\Controllers\SuperAdmin\Events;

use App\Http\Controllers\SuperAdmin\SuperAdminBaseController;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;

class SuperAdminEventsController extends SuperAdminBaseController
{
    public function index(Request $request, $status = null)
    {
        $viewData = $this->getViewData('events');

        $query = Event::with('user', 'organization')->latest(); 

        $search = $request->get('search');
        $eventStatus = $status;
        $categoryId = $request->get('category');

        if ($eventStatus && in_array($eventStatus, ['draft', 'ongoing', 'upcoming', 'ended'])) {
            $query->where('status', $eventStatus);
        }

        if ($categoryId && $categoryId !== 'all') {
            $query->where('categories_id', $categoryId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhereHas('organization', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%$search%");
                    })
                    ->orWhereHas('user', function ($q3) use ($search) {
                        $q3->where('name', 'like', "%$search%");
                    });
            });
        }

        $events = $query->paginate(10)->appends($request->all());

        $categories = Category::all();

        $statusColors = [
            'draft' => 'text-white bg-gradient-to-r from-amber-400 to-amber-600 dark:from-amber-600 dark:to-amber-800',
            'ongoing' => 'text-white bg-gradient-to-r from-emerald-400 to-emerald-600 dark:from-emerald-600 dark:to-emerald-800',
            'upcoming' => 'text-white bg-gradient-to-r from-blue-400 to-blue-600 dark:from-blue-600 dark:to-blue-800',
            'ended' => 'text-white bg-gradient-to-r from-rose-400 to-rose-600 dark:from-rose-600 dark:to-rose-800',
        ];

        $defaultClass = 'text-gray-700 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-500 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-indigo-700 dark:hover:text-indigo-100';

        $allClass = 'text-white bg-gradient-to-r from-gray-400 to-gray-600';

        return view('layouts.superAdmin.index', array_merge($viewData, [
            'events' => $events,
            'eventStatus' => $eventStatus,
            'categories' => $categories,
            'statusColors' => $statusColors,
            'defaultClass' => $defaultClass,
            'allClass' => $allClass,
            'selectedCategory' => $categoryId,
            'search' => $search,
        ]));
    }
}
