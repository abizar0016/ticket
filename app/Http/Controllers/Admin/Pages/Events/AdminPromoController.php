<?php

namespace App\Http\Controllers\Admin\Pages\Events;

use App\Models\Event;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Promo;
use Illuminate\Support\Facades\DB;

class AdminPromoController extends AdminBaseController
{
    public function index($eventId)
    {
        $events = Event::with(['user', 'organization'])
            ->findOrFail($eventId);

        $viewData = $this->getEventsViewData('promos', $eventId);

        $search = request('search');
        $statusFilter = request('status');

        // Query promos with order count
        $promosQuery = Promo::withCount([
            'orders as order_count' => function ($query) {
                $query->where('status', 'paid');
            },
        ])
            ->where('event_id', $eventId)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Summary stats
        $totalDiscounts = OrderItem::whereHas('order', function ($q) use ($events) {
            $q->where('status', 'paid')
                ->where('event_id', $events->id);
        })
            ->selectRaw('SUM(price_before_discount - total_price) as total')
            ->value('total') ?? 0;

        $totalPromos = Promo::where('event_id', $eventId)->count();

        $activePromos = Promo::where('event_id', $eventId)
            ->where(function ($query) {
                $query->where('max_uses', 0)
                    ->orWhereRaw('(SELECT COUNT(*) FROM orders WHERE orders.promo_id) < max_uses');
            })->count();

        // Chart data
        $chartLabels = Promo::where('event_id', $eventId)
            ->orderBy('created_at')
            ->pluck('code');

        $revenueData = OrderItem::whereHas('order', function ($q) use ($eventId) {
            $q->where('event_id', $eventId)
                ->where('status', 'paid');
        })
            ->whereNotNull('promo_id')
            ->select('promo_id', DB::raw('SUM(total_price) as revenue'))
            ->groupBy('promo_id')
            ->pluck('revenue', 'promo_id');

        $salesData = Promo::where('event_id', $eventId)
            ->withCount([
                'orders as paid_orders_count' => function ($q) {
                    $q->where('status', 'paid');
                },
            ])
            ->orderBy('created_at')
            ->pluck('paid_orders_count');

        return view('pages.admins.index', array_merge($viewData, [
            'events' => $events,
            'promos' => $promosQuery,
            'totalPromos' => $totalPromos,
            'activePromos' => $activePromos,
            'totalDiscounts' => $totalDiscounts,
            'search' => $search,
            'statusFilter' => $statusFilter,
            'chartLabels' => $chartLabels,
            'revenueData' => $revenueData,
            'salesData' => $salesData,
        ]));
    }
}
