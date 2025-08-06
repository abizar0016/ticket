<?php

namespace App\Http\Controllers\PageController;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderItem;

class DashboardController extends BaseController
{
    public function index($id)
    {
        $event = $this->getEvent($id);
        $viewData = $this->getViewData('dashboard', $event);
        $tz = $viewData['tz'];
        
        $labels = [];
        $revenues = [];
        $sales = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now($tz)->subDays($i)->toDateString();
            $label = Carbon::now($tz)->subDays($i)->format('d M');

            $items = OrderItem::whereDate('created_at', $date)
                ->whereHas('order', fn($q) => $q->where('status', 'paid'))
                ->whereHas('product', fn($q) => $q->where('event_id', $event->id))
                ->get();

            $labels[] = $label;
            $revenues[] = $items->sum('total_price');
            $sales[] = $items->sum('quantity');
        }

        return view('Admin.eventDashboard.index', array_merge($viewData, [
            'chartLabels' => $labels,
            'revenueData' => $revenues,
            'salesData' => $sales,
            'orderItemsCount' => OrderItem::whereHas('order', fn($q) => $q->where('status', 'paid'))
                ->whereHas('product', fn($q) => $q->where('event_id', $event->id))
                ->sum('quantity'),
            'revenueTotal' => OrderItem::whereHas('order', fn($q) => $q->where('status', 'paid'))
                ->whereHas('product', fn($q) => $q->where('event_id', $event->id))
                ->sum('total_price'),
            'completedOrders' => Order::where('status', 'paid')
                ->whereHas('items.product', fn($q) => $q->where('event_id', $event->id))
                ->count(),
            'attendeeCount' => Attendee::whereHas('order', function ($q) use ($event) {
                $q->where('status', 'paid')
                    ->whereHas('items.product', fn($q2) => $q2->where('event_id', $event->id));
            })->count(),
        ]));
    }

}