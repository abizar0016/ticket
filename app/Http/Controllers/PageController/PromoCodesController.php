<?php

namespace App\Http\Controllers\PageController;

use App\Http\Controllers\Controller;
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

        $promosQuery = PromoCode::with(['product'])
            ->whereHas('product', fn($q) => $q->where('event_id', $event->id))
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', "%{$search}%")
                        ->orWhereHas('product', fn($q) => $q->where('title', 'like', "%{$search}%"));
                });
            })
            ->when($statusFilter, fn($q) => $this->applyPromoStatusFilter($q, $statusFilter));

        return view('Admin.eventDashboard.index', array_merge($viewData, [
            'promos' => $promosQuery->orderBy('created_at', 'desc')->paginate(10),
            'products' => Product::where('event_id', $event->id)->orderBy('title')->get(),
            'totalPromos' => PromoCode::whereHas('product', fn($q) => $q->where('event_id', $event->id))->count(),
            'activePromos' => PromoCode::whereHas('product', fn($q) => $q->where('event_id', $event->id))
                ->where(function ($query) {
                    $query->where('max_uses', 0)
                        ->orWhereRaw('(SELECT COUNT(*) FROM order_items WHERE order_items.promo_code_id = promo_codes.id) < max_uses');
                })->count(),
            'totalDiscounts' => OrderItem::whereHas('order', fn($q) => $q->where('status', 'paid'))
                ->whereHas('product', fn($q) => $q->where('event_id', $event->id))
                ->whereNotNull('promo_code_id')
                ->sum(DB::raw('price_before_discount - total_price')),
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
