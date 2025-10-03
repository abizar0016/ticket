<?php

namespace App\Http\Controllers\SuperAdmin\Events;

use App\Models\Event;
use App\Models\Product;

class SuperAdminEventsProductsController extends SuperAdminEventsBaseController
{
    public function index($eventId)
    {
        $events = Event::with(['user', 'organization'])
            ->findOrFail($eventId);

        $viewData = $this->getEventsViewData('products', id: $eventId);

        $search = request('search');
        $activeTab = request('tab', 'tickets');

        $baseQuery = Product::where('event_id', $events->id)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            });

        $tickets = (clone $baseQuery)->where('type', 'ticket')
            ->withSum(['orderItems as total_sold' => fn ($q) => $q->whereHas('order', fn ($q) => $q->where('status', 'paid'))], 'quantity')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'tickets_page')
            ->appends(['tab' => 'tickets']);

        $merchandise = (clone $baseQuery)->where('type', '!=', 'ticket')
            ->withSum(['orderItems as total_sold' => fn ($q) => $q->whereHas('order', fn ($q) => $q->where('status', 'paid'))], 'quantity')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'merchandise_page')
            ->appends(['tab' => 'merchandise']);

        return view('layouts.superAdmin.index', array_merge($viewData, [
            'events' => $events,
            'tickets' => $tickets,
            'merchandise' => $merchandise,
            'ticketCount' => $tickets->total(),
            'merchandiseCount' => $merchandise->total(),
            'activeTab' => $activeTab,
            'search' => $search,
            'statusOptions' => [
                'all' => 'All Items',
                'active' => 'Currently Available',
                'upcoming' => 'Upcoming',
                'ended' => 'Ended',
            ],
        ]));
    }
}
