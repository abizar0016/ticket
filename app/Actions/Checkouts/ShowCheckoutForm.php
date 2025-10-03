<?php

namespace App\Actions\Checkouts;

use App\Actions\Checkouts\Concerns\HandlesCheckoutData;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class ShowCheckoutForm
{
    use HandlesCheckoutData;

    public function handle(string $token)
    {
        $checkoutData = $this->getCheckoutData($token);

        if (! $checkoutData) {
            return redirect()->route('home')->with('error', 'Checkout session expired');
        }

        $productIds = array_merge(
            array_column($checkoutData['tickets'], 'product_id'),
            array_column($checkoutData['merchandise'] ?? [], 'product_id')
        );

        return view('pages.Customers.checkout.form', [
            'checkoutData' => $checkoutData,
            'products' => Product::with('event')
                ->whereIn('id', $productIds)
                ->get()
                ->keyBy('id'),
            'tickets' => $checkoutData['tickets'],
        ]);
    }
}
