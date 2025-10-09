<?php

namespace App\Http\Controllers\SuperAdmin\Orders;

use App\Http\Controllers\SuperAdmin\SuperAdminBaseController;
use App\Models\Event;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class SuperAdminRevenueReportController extends SuperAdminBaseController
{
    public function index()
    {
        $viewData = $this->getViewData('revenue-reports');

        $totalRevenue = Order::where('status', 'paid')
            ->select(DB::raw('SUM(total_price + unique_price) as total'))
            ->value('total');

        $revenueByEvent = Event::select('events.id', 'events.title', DB::raw('SUM(orders.total_price + orders.unique_price) as revenue'))
            ->join('orders', 'orders.event_id', '=', 'events.id')
            ->where('orders.status', 'paid')
            ->groupBy('events.id', 'events.title')
            ->get();

        // Detail order (opsional)

        $orders = Order::with('event')
            ->select('*', DB::raw('(total_price + unique_price) as uniqueAmount'))
            ->where('status', 'paid')
            ->latest()
            ->paginate(10);

        return view('layouts.superAdmin.index', array_merge($viewData, [
            'totalRevenue' => $totalRevenue,
            'revenueByEvent' => $revenueByEvent,
            'orders' => $orders,
        ]));
    }
}
