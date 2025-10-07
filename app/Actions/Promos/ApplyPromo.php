<?php

namespace App\Actions\Promos;

use App\Models\Order;
use App\Models\Product;
use App\Models\Promo;
use App\Services\Promos\PromoService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ApplyPromo
{
    public function handle(string $token, string $promoCode): JsonResponse
    {
        $service = app(PromoService::class);
        $checkoutData = $service->getCheckoutData($token);

        if (! $checkoutData) {
            Log::warning('Checkout data tidak valid atau kadaluarsa', ['token' => $token]);

            return response()->json([
                'success' => false,
                'message' => 'Sesi checkout tidak valid atau telah kadaluarsa',
            ], 400);
        }

        $promo = Promo::where('code', $promoCode)->first();

        if (! $promo) {
            Log::info('Promo tidak ditemukan sama sekali', ['code' => $promoCode]);

            return response()->json([
                'success' => false,
                'message' => 'Kode promo tidak ditemukan',
            ], 400);
        }

        // Cek kuota jika ada batas
        $usedCount = Order::where('promo_id', $promo->id)->count();

        // Jika max_uses null atau 0 → unlimited
        if ($promo->max_uses > 0 && $usedCount >= $promo->max_uses) {
            Log::info('Kuota promo habis', [
                'code' => $promo->code,
                'max_uses' => $promo->max_uses,
                'used_count' => $usedCount,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Kuota penggunaan promo ini telah habis',
            ], 400);
        }

        // Ambil semua product id dari checkout
        $productIds = array_merge(
            array_column($checkoutData['tickets'] ?? [], 'product_id'),
            array_column($checkoutData['merchandise'] ?? [], 'product_id')
        );

        if (empty($productIds)) {
            Log::info('Keranjang belanja kosong saat mencoba apply promo', ['token' => $token, 'code' => $promoCode]);

            return response()->json([
                'success' => false,
                'message' => 'Keranjang belanja kosong',
            ], 400);
        }

        $products = Product::whereIn('id', $productIds)->get();
        $ticketQty = collect($checkoutData['tickets'] ?? [])->sum('quantity');
        $merchQty = collect($checkoutData['merchandise'] ?? [])->sum('quantity');

        // Validasi jenis promo
        if ($promo->is_ticket && ! $promo->is_merchandise && $ticketQty === 0) {
            return $this->promoError('Promo ini hanya untuk tiket, namun keranjang tidak berisi tiket', $promo->code, ['ticketQty' => $ticketQty]);
        }

        if ($promo->is_merchandise && ! $promo->is_ticket && $merchQty === 0) {
            return $this->promoError('Promo ini hanya untuk merchandise, namun keranjang tidak berisi merchandise', $promo->code, ['merchQty' => $merchQty]);
        }

        if ($promo->is_ticket && $promo->is_merchandise && $ticketQty === 0 && $merchQty === 0) {
            return $this->promoError('Promo ini membutuhkan setidaknya 1 tiket atau merchandise di keranjang', $promo->code);
        }

        // Cek event
        $cartEventIds = $products->pluck('event_id')->unique();
        if ($cartEventIds->count() > 1 || ! $cartEventIds->contains($promo->event_id)) {
            return $this->promoError('Promo tidak valid untuk event yang dipilih', $promo->code, [
                'promo_event_id' => $promo->event_id,
                'cart_event_ids' => $cartEventIds->toArray(),
            ]);
        }

        // Minimal tiket / merchandise
        if ($promo->min_tickets && $ticketQty < $promo->min_tickets) {
            return $this->promoError("Promo ini membutuhkan minimal {$promo->min_tickets} tiket", $promo->code, ['ticketQty' => $ticketQty]);
        }

        if ($promo->min_merchandise && $merchQty < $promo->min_merchandise) {
            return $this->promoError("Promo ini membutuhkan minimal {$promo->min_merchandise} merchandise", $promo->code, ['merchQty' => $merchQty]);
        }

        // Apply promo ke checkout data
        $checkoutData['applied_promo'] = [
            'id' => $promo->id,
            'event_id' => $promo->event_id,
            'discount' => $promo->discount,
            'type' => $promo->type,
            'code' => $promo->code,
            'is_ticket' => $promo->is_ticket,
            'is_merchandise' => $promo->is_merchandise,
            'min_tickets' => $promo->min_tickets,
            'min_merchandise' => $promo->min_merchandise,
        ];

        Cache::put('checkout:'.$token, $checkoutData, Carbon::parse($checkoutData['expires_at']));
        Session::put('checkout_data', $checkoutData);

        Log::info('Promo berhasil diterapkan', [
            'token' => $token,
            'code' => $promo->code,
            'discount' => $promo->discount,
            'type' => $promo->type,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Promo berhasil diterapkan',
            'promo' => [
                'code' => $promo->code,
                'discount' => $promo->discount,
                'type' => $promo->type,
            ],
            'redirect' => route('checkout.form', ['token' => $token]),
        ]);
    }

    private function promoError(string $message, string $code, array $context = []): JsonResponse
    {
        Log::info($message, array_merge(['code' => $code], $context));

        return response()->json(['success' => false, 'message' => $message], 400);
    }
}
