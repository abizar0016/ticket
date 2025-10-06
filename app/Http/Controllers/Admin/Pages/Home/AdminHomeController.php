<?php

namespace App\Http\Controllers\Admin\Pages\Home;

use App\Http\Controllers\SuperAdmin\SuperAdminBaseController;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class AdminHomeController extends SuperAdminBaseController
{
    public function index(Request $request, $status = null)
    {
        $viewData = $this->getViewData('events');
        $user = Auth::user();

        $search = $request->get('search');
        $eventStatus = $status;
        $categoryId = $request->get('category');

        // base query
        $query = Event::with(['user', 'organization', 'categories', 'products'])->latest();

        // filter status
        if ($eventStatus && in_array($eventStatus, ['draft', 'ongoing', 'upcoming', 'ended'])) {
            $query->where('status', $eventStatus);
        }

        // filter kategori
        if ($categoryId && $categoryId !== 'all') {
            $eventsTable = (new Event)->getTable();

            if (Schema::hasColumn($eventsTable, 'category_id')) {
                $query->where('category_id', $categoryId);
            } elseif (Schema::hasColumn($eventsTable, 'categories_id')) {
                $query->where('categories_id', $categoryId);
            } else {
                $query->whereHas('categories', function ($q) use ($categoryId) {
                    $q->where('id', $categoryId);
                });
            }
        }

        // filter pencarian
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('organization', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('user', function ($q3) use ($search) {
                        $q3->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('categories', function ($q4) use ($search) {
                        $q4->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // filter role: kalau bukan superadmin, hanya event miliknya
        $query->when($user->role !== 'superadmin', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        });

        // eksekusi query
        $events = $query->paginate(10)->appends($request->all());
        $categories = Category::all();

        // status warna dan ikon
        $statusColors = [
            'draft' => 'text-white bg-gradient-to-r from-amber-400 to-amber-600 dark:from-amber-600 dark:to-amber-800',
            'ongoing' => 'text-white bg-gradient-to-r from-emerald-400 to-emerald-600 dark:from-emerald-600 dark:to-emerald-800',
            'upcoming' => 'text-white bg-gradient-to-r from-blue-400 to-blue-600 dark:from-blue-600 dark:to-blue-800',
            'ended' => 'text-white bg-gradient-to-r from-rose-400 to-rose-600 dark:from-rose-600 dark:to-rose-800',
        ];

        $defaultClass = 'text-gray-700 dark:text-gray-100 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-indigo-700 dark:hover:text-indigo-100';
        $allClass = 'text-white bg-gradient-to-r from-gray-400 to-gray-600';

        $statusIcons = [
            'draft' => 'ri-draft-line',
            'ended' => 'ri-checkbox-circle-line',
            'ongoing' => 'ri-flashlight-line',
            'upcoming' => 'ri-time-line',
        ];

        // tambahkan status label & icon ke setiap event
        foreach ($events as $event) {
            if (! $event->is_published) {
                $event->status_label = 'Draft';
                $event->status_color = $statusColors['draft'];
                $event->status_icon = $statusIcons['draft'];
            } else {
                $status = $event->status;
                $event->status_label = ucfirst($status);
                $event->status_color = $statusColors[$status] ?? $defaultClass;
                $event->status_icon = $statusIcons[$status] ?? '';
            }
        }

        // hitung jumlah event sesuai query user (bukan semua)
        $eventsCount   = (clone $query)->count();
        $ongoingCount  = (clone $query)->where('status', 'ongoing')->count();
        $upcomingCount = (clone $query)->where('status', 'upcoming')->count();
        $endedCount    = (clone $query)->where('status', 'ended')->count();

        // hitung attendees per event
        $attendeesCount = [];
        foreach ($events as $event) {
            if (method_exists($event, 'attendees')) {
                $attendeesCount[$event->id] = $event->attendees()
                    ->whereIn('status', ['active', 'used'])
                    ->whereHas('order', function ($q) {
                        $q->where('status', 'paid');
                    })->count();
            } else {
                $attendeesCount[$event->id] = 0;
            }
        }

        $organization = $user->organization ?? null;

        return view('layouts.admin.index', array_merge($viewData, [
            'events' => $events,
            'eventStatus' => $eventStatus,
            'categories' => $categories,
            'selectedCategory' => $categoryId,
            'search' => $search,
            'statusColors' => $statusColors,
            'defaultClass' => $defaultClass,
            'allClass' => $allClass,
            'statusIcons' => $statusIcons,
            'eventsCount' => $eventsCount,
            'ongoingCount' => $ongoingCount,
            'upcomingCount' => $upcomingCount,
            'endedCount' => $endedCount,
            'attendeesCount' => $attendeesCount,
            'organization' => $organization,
        ]));
    }
}
