<?php

namespace App\Actions\Checkouts;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CreateCheckoutSession
{
    protected function generateCheckoutToken(): string
    {
        do {
            $token = 'chk_' . Str::random(20);
        } while (Cache::has('checkout:' . $token));

        return $token;
    }

public function handle(Request $request)
    {
        $validated = $request->validate([
            'tickets' => 'required|array|min:1',// validasi minimal 1 di array tickets
            'tickets.*' => 'integer|min:0',
            'merchandise' => 'nullable|array',
            'merchandise.*' => 'nullable|integer',
        ]);

        // return invalid ketika tidak ada tiket yang dipilih
        if (collect($validated['tickets'])->sum() < 1) {
            return redirect()->back()->withErrors(['tickets' => 'You must select at least one ticket.']);
        }

        $token = $this->generateCheckoutToken();
        $expiresAt = now()->addMinutes(30);

        $checkoutData = [
            'token' => $token,
            'tickets' => collect($validated['tickets'])
                ->filter(fn($qty) => $qty > 0)// filter hanya yang qty > 0
                ->map(fn($qty, $id) => ['product_id' => (int)$id, 'quantity' => (int)$qty])
                ->values()
                ->all(),
            'merchandise' => collect($validated['merchandise'] ?? [])
                ->filter(fn($qty) => $qty > 0)// filter hanya yang qty > 0
                ->map(fn($qty, $id) => ['product_id' => (int)$id, 'quantity' => (int)$qty])
                ->values()
                ->all(),
            'expires_at' => $expiresAt,
            'created_at' => now(),
            'applied_promo' => null,
        ];

        Cache::put('checkout:' . $token, $checkoutData, $expiresAt);
        Session::put('checkout_token', $token);
        Session::put('checkout_data', $checkoutData);

        return redirect()->route('checkout.form', ['token' => $token]);
    }

}
