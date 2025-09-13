<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use Carbon\Carbon;
use App\Models\Event;
use App\Models\Order;
use App\Models\OrderItem;

class AdminDashboardController extends AdminBaseController
{
    public function index($eventId)
    {
        $event = Event::with(['user', 'location', 'organization'])
            ->findOrFail($eventId);

        $viewData = $this->getViewData('dashboard', $eventId);

        // Ambil data chart harian
        [$dailyLabels, $dailyRevenue, $dailySales] = $this->getDailyStats($event);

        // Ambil data summary
        $summary = $this->getEventSummary($event);

        return view('Admin.eventDashboard.index', array_merge($viewData, [
            'event'        => $event,
            'chartLabels'  => $dailyLabels,
            'revenueData'  => $dailyRevenue,
            'salesData'    => $dailySales,
            'summary'      => $summary,
        ]));
    }

    private function getDailyStats(Event $event): array
    {
        $labels = [];
        $revenues = [];
        $sales = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $label = Carbon::now()->subDays($i)->format('d M');

            $items = OrderItem::whereDate('created_at', $date)
                ->whereHas('order', fn($q) => $q->where('status', 'paid'))
                ->whereHas('product', fn($q) => $q->where('event_id', $event->id))
                ->get();

            $labels[] = $label;
            $revenues[] = $items->sum('total_price');
            $sales[] = $items->sum('quantity');
        }

        return [$labels, $revenues, $sales];
    }

    private function getEventSummary(Event $event): array
    {
        return [
            'totalTicketsSold' => OrderItem::whereHas('order', fn($q) => $q->where('status', 'paid'))
                ->whereHas('product', fn($q) => $q->where('event_id', $event->id))
                ->sum('quantity'),

            'totalRevenue' => OrderItem::whereHas('order', fn($q) => $q->where('status', 'paid'))
                ->whereHas('product', fn($q) => $q->where('event_id', $event->id))
                ->sum('total_price'),

            'completedOrders' => Order::where('status', 'paid')
                ->whereHas('items.product', fn($q) => $q->where('event_id', $event->id))
                ->count(),

            'attendeeCount' => Attendee::whereHas('order', function ($q) use ($event) {
                $q->where('status', 'paid')
                  ->whereHas('items.product', fn($q2) => $q2->where('event_id', $event->id));
            })->count(),
        ];
    }

}