<?php

namespace App\Http\Controllers\SuperAdmin\Events;

use App\Models\Event;
use App\Models\Order;

class SuperAdminEventsOrdersController extends SuperAdminEventsBaseController
{
    public function index($eventId)
    {
        $events = Event::with(['user', 'organization'])
            ->findOrFail($eventId);

        $viewData = $this->getEventsViewData('orders', $eventId);

        $search = request('search');

        $ordersQuery = Order::whereHas('items.product', function ($q) use ($events) {
            $q->where('event_id', $events->id);
        })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->select('*')
            ->selectRaw('(total_price + unique_price) as uniqueAmount');

        $orders = $ordersQuery->orderByDesc('created_at')->paginate(10);
        $totalOrders = $orders->total();

        $paidOrdersCount = Order::whereHas('items.product', fn ($q) => $q->where('event_id', $events->id))
            ->where('status', 'paid')->count();

        $pendingOrdersCount = Order::whereHas('items.product', fn ($q) => $q->where('event_id', $events->id))
            ->where('status', 'pending')->count();

        $totalOrders = $paidOrdersCount + $pendingOrdersCount;

        $paidPercentage = $totalOrders > 0 ? round(($paidOrdersCount / $totalOrders) * 100) : 0;
        $pendingPercentage = $totalOrders > 0 ? round(($pendingOrdersCount / $totalOrders) * 100) : 0;

        $totalRevenue = Order::whereHas('items.product', fn ($q) => $q->where('event_id', $events->id))
            ->where('status', 'paid')->sum('total_price');

        return view('layouts.superAdmin.index', array_merge($viewData, [
            'events' => $events,
            'orders' => $orders,
            'paidOrdersCount' => $paidOrdersCount,
            'pendingOrdersCount' => $pendingOrdersCount,
            'paidPercentage' => $paidPercentage,
            'pendingPercentage' => $pendingPercentage,
            'totalRevenue' => $totalRevenue,
            'search' => $search,
        ]));
    }

    public function show($eventId, $orderId)
    {
        $events = Event::with(['user', 'organization'])
            ->findOrFail($eventId);

        $viewData = $this->getEventsViewData('orders-show', $eventId);

        $order = Order::with(['items.product.event', 'attendees'])
            ->where('id', $orderId)
            ->whereHas('items.product', fn ($q) => $q->where('event_id', $eventId))
            ->firstOrFail();

        $uniquePrice = $order->unique_price ?? 0;
        $order->uniqueAmount = $order->total_price + $uniquePrice;

        $attendees = $order->attendees;

        return view('layouts.superAdmin.index', array_merge($viewData, [
            'events' => $events,
            'order' => $order,
            'attendees' => $attendees,
        ]));
    }
}
