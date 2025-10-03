<?php

namespace App\Actions\Promos;

use App\Services\Promos\PromoService;
use Carbon\Carbon;
use Illuminate\Support\Facades\{Cache, Session};
use Illuminate\Http\JsonResponse;

class RemovePromo
{
    public function handle(string $token): JsonResponse
    {
        $service = app(PromoService::class);
        $checkoutData = $service->getCheckoutData($token);

        if (!$checkoutData) {
            return response()->json(['success' => false, 'message' => 'Invalid checkout session'], 400);
        }

        $checkoutData['applied_promo'] = null;

        Cache::put('checkout:' . $token, $checkoutData, Carbon::parse($checkoutData['expires_at']));
        Session::put('checkout_data', $checkoutData);

        return response()->json([
            'success' => true,
            'redirect' => route('checkout.form', ['token' => $token])
        ]);
    }
}
