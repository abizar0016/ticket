<?php

namespace App\Http\Controllers\PageController;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromoCodesController extends BaseController
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
            })
            ->when($statusFilter, fn($q) => $this->applyPromoStatusFilter($q, $statusFilter));


        return view('Admin.eventDashboard.index', array_merge($viewData, [
            'promos' => $promosQuery->orderBy('created_at', 'desc')->paginate(10),
            'totalPromos' => PromoCode::count(),
            'activePromos' => PromoCode::where(function ($query) {
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

    protected function applyPromoStatusFilter($query, string $status)
    {
        return match ($status) {
            'active' => $query->where(function ($q) {
                    $q->where('max_uses', 0)
                    ->orWhereRaw('(SELECT COUNT(*) FROM order_items WHERE order_items.promo_code_id = promo_codes.id) < max_uses');
                }),
            'used' => $query->where(function ($q) {
                    $q->where('max_uses', '>', 0)
                    ->whereRaw('(SELECT COUNT(*) FROM order_items WHERE order_items.promo_code_id = promo_codes.id) >= max_uses');
                }),
            'unlimited' => $query->where('max_uses', 0),
            'limited' => $query->where('max_uses', '>', 0),
            default => $query
        };
    }
}
