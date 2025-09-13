<?php

namespace App\Http\Controllers\Customers\Actions;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\PromoCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Cache, Session};

class CustomersPromoController extends Controller
{
    public function applyPromo(Request $request)
    {
        $request->validate([
            'promo_code' => 'required|string|max:50',
            'token' => 'required|string'
        ]);

        $token = $request->input('token');
        $checkoutData = $this->getCheckoutData($token);

        if (!$checkoutData) {
            return response()->json(['success' => false, 'message' => 'Sesi checkout tidak valid atau telah kadaluarsa'], 400);
        }

        $promo = PromoCode::where('code', $request->input('promo_code'))
            ->where(function ($q) {
                $q->where('max_uses', '>', 0)->orWhereNull('max_uses');
            })->first();

        if (!$promo) {
            return response()->json(['success' => false, 'message' => 'Kode promo tidak di temukan atau telah kadaluarsa'], 400);
        }

        // Check usage quota
        $usedCount = Order::where('promo_id', $promo->id)->count();
        if (!is_null($promo->max_uses) && $usedCount >= $promo->max_uses) {
            return response()->json(['success' => false, 'message' => 'Kuota penggunaan promo ini telah habis'], 400);
        }

        // Get all products in cart
        $productIds = array_merge(
            array_column($checkoutData['tickets'] ?? [], 'product_id'),
            array_column($checkoutData['merchandise'] ?? [], 'product_id')
        );

        if (empty($productIds)) {
            return response()->json(['success' => false, 'message' => 'Keranjang belanja kosong'], 400);
        }

        $products = Product::whereIn('id', $productIds)->get();

        // Calculate total quantity by type
        $ticketQty = collect($checkoutData['tickets'] ?? [])->sum('quantity');
        $merchQty = collect($checkoutData['merchandise'] ?? [])->sum('quantity');

        // Validate promo applicability
        if ($promo->is_ticket && !$promo->is_merchandise && $ticketQty === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Promo ini hanya untuk tiket, namun keranjang tidak berisi tiket'
            ], 400);
        }

        if ($promo->is_merchandise && !$promo->is_ticket && $merchQty === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Promo ini hanya untuk merchandise, namun keranjang tidak berisi merchandise'
            ], 400);
        }

        if (($promo->is_ticket && $promo->is_merchandise) && ($ticketQty === 0 && $merchQty === 0)) {
            return response()->json([
                'success' => false,
                'message' => 'Promo ini membutuhkan setidaknya 1 tiket atau merchandise di keranjang'
            ], 400);
        }

        // Validate event match
        $productsEventIds = $products->pluck('event_id')->unique();
        if ($productsEventIds->count() > 1 || !$productsEventIds->contains($promo->event_id)) {
            return response()->json([
                'success' => false,
                'message' => 'Promo tidak valid untuk event yang dipilih'
            ], 400);
        }

        // Validate minimum quantity if specified
        if ($promo->min_tickets && $ticketQty < $promo->min_tickets) {
            return response()->json([
                'success' => false,
                'message' => "Promo ini membutuhkan minimal {$promo->min_tickets} tiket"
            ], 400);
        }

        if ($promo->min_merchandise && $merchQty < $promo->min_merchandise) {
            return response()->json([
                'success' => false,
                'message' => "Promo ini membutuhkan minimal {$promo->min_merchandise} merchandise"
            ], 400);
        }

        $checkoutData['applied_promo'] = [
            'id' => $promo->id,
            'event_id' => $promo->event_id,
            'discount' => $promo->discount,
            'type' => $promo->type,
            'code' => $promo->code,
            'is_ticket' => $promo->is_ticket,
            'is_merchandise' => $promo->is_merchandise,
            'min_tickets' => $promo->min_tickets,
            'min_merchandise' => $promo->min_merchandise
        ];

        Cache::put('checkout:' . $token, $checkoutData, Carbon::parse($checkoutData['expires_at']));
        Session::put('checkout_data', $checkoutData);

        return response()->json([
            'success' => true,
            'message' => 'Promo berhasil diterapkan',
            'promo' => [
                'code' => $promo->code,
                'discount' => $promo->discount,
                'type' => $promo->type
            ],
            'redirect' => route('checkout.form', ['token' => $token])
        ]);
    }

    public function removePromo(Request $request)
    {
        $validated = $request->validate(['token' => 'required|string']);

        $checkoutData = $this->getCheckoutData($validated['token']);
        if (!$checkoutData) {
            return response()->json(['success' => false, 'message' => 'Invalid checkout session'], 400);
        }

        $checkoutData['applied_promo'] = null;
        Cache::put('checkout:' . $checkoutData['token'], $checkoutData, Carbon::parse($checkoutData['expires_at']));
        Session::put('checkout_data', $checkoutData);

        return response()->json([
            'success' => true,
            'redirect' => route('checkout.form', ['token' => $checkoutData['token']])
        ]);
    }
}
