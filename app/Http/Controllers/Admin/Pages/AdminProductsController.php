<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductsController extends AdminBaseController
{
    public function index($id)
    {
        $event = $this->getEvent($id);
        $viewData = $this->getViewData('ticket-products', $event);
        $search = request('search');
        $activeTab = request('tab', 'tickets');

        $baseQuery = Product::where('event_id', $event->id)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            });

        $tickets = (clone $baseQuery)->where('type', 'ticket')
            ->withSum(['orderItems as total_sold' => fn($q) => $q->whereHas('order', fn($q) => $q->where('status', 'paid'))], 'quantity')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'tickets_page')
            ->appends(['tab' => 'tickets']);

        $merchandise = (clone $baseQuery)->where('type', '!=', 'ticket')
            ->withSum(['orderItems as total_sold' => fn($q) => $q->whereHas('order', fn($q) => $q->where('status', 'paid'))], 'quantity')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'merchandise_page')
            ->appends(['tab' => 'merchandise']);

        return view('Admin.eventDashboard.index', array_merge($viewData, [
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
                'ended' => 'Ended'
            ]
        ]));
    }
}
