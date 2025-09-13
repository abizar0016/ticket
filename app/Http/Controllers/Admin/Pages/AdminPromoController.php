<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPromoController extends AdminBaseController
{
    public function index($id)
    {
        $event = $this->getEvent($id);
        $viewData = $this->getViewData('promo-codes', $event);
        $search = request('search');
        $statusFilter = request('status');

        $promosQuery = PromoCode::withCount([
            'orders as order_count' => function ($query) {
                $query->where('status', 'paid');
            }
        ])
            ->where('event_id', $event->id)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");
                });
            });

        return view('Admin.eventDashboard.index', array_merge($viewData, [
            'promos' => $promosQuery->orderBy('created_at', 'desc')->paginate(10),

            'totalPromos' => PromoCode::where('event_id', $event->id)->count(),

            'activePromos' => PromoCode::where('event_id', $event->id)
                ->where(function ($query) {
                    $query->where('max_uses', 0)
                        ->orWhereRaw('(SELECT COUNT(*) FROM orders WHERE orders.promo_id = promo_codes.id) < max_uses');
                })->count(),

            'totalDiscounts' => OrderItem::whereHas('order', function ($q) use ($event) {
                $q->where('status', 'paid')
                    ->whereHas('event', function ($q) use ($event) {
                        $q->where('id', $event->id);
                    });
            })
                ->selectRaw('SUM(price_before_discount - total_price) as total')
                ->value('total') ?? 0,

            'search' => $search,
            'statusFilter' => $statusFilter,
        ]));
    }
}
