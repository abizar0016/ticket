<?php

namespace App\Http\Controllers\SuperAdmin\Orders;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SuperAdmin\SuperAdminBaseController;
use App\Models\Event;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuperAdminRevenueReportController extends SuperAdminBaseController
{
    public function index()
    {
        $viewData = $this->getViewData('revenue-reports');
        
        $totalRevenue = Order::where('status', 'paid')->sum('total_price');

        $revenueByEvent = Event::select('events.id', 'events.title', DB::raw('SUM(orders.total_price) as revenue'))
            ->join('orders', 'orders.event_id', '=', 'events.id')
            ->where('orders.status', 'paid')
            ->groupBy('events.id', 'events.title')
            ->get();

        // Revenue per bulan
        $revenueByMonth = Order::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(total_price) as revenue')
            )
            ->where('status', 'paid')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Detail order (opsional)
        $orders = Order::with('event')
            ->where('status', 'paid')
            ->latest()
            ->paginate(10);

        return view('layouts.superAdmin.index', array_merge($viewData, [
            'totalRevenue' => $totalRevenue,
            'revenueByEvent' => $revenueByEvent,
            'revenueByMonth' => $revenueByMonth,
            'orders' => $orders,
        ]));
    }
}
