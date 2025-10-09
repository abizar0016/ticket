<?php

namespace App\Actions\Checkouts;

use App\Actions\Checkouts\Concerns\HandlesCheckoutData;
use App\Models\Activity;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SubmitCheckout
{
    use HandlesCheckoutData;

    public function handle(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'identity_type' => 'required|string|in:KTP,SIM,Paspor,Kartu Pelajar',
            'identity_number' => 'required|numeric',
            'attendees' => 'nullable|array',
            'attendees.*.*.name' => 'required_with:attendees|string|max:255',
            'attendees.*.*.email' => 'required_with:attendees|email|max:255',
            'attendees.*.*.phone' => 'required_with:attendees|string|max:255',
        ]);

        $checkoutData = (new ShowCheckoutForm)->getCheckoutData($validated['token'] ?? null);
        if (! $checkoutData) {
            return back()->with('error', 'Invalid checkout session');
        }

        DB::beginTransaction();
        try {
            $promoId = $checkoutData['applied_promo']['id'] ?? null;

            $firstProductId = $checkoutData['tickets'][0]['product_id'] ?? ($checkoutData['merchandise'][0]['product_id'] ?? null);
            if (! $firstProductId) {
                throw new \Exception('No products found in checkout');
            }
            $eventId = Product::findOrFail($firstProductId)->event_id;

            $normalTotal = $this->calculateNormalTotal($checkoutData);

            $cacheKey = 'checkout_unique_code_'.$checkoutData['token'];
            $uniquePrice = Cache::get($cacheKey, 0);

            $order = Order::create([
                'user_id' => Auth::id(),
                'event_id' => $eventId,
                'promo_id' => $promoId,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $this->normalizePhone($validated['phone']),
                'status' => 'pending',
                'identity_type' => $validated['identity_type'],
                'identity_number' => $validated['identity_number'],
                'total_price' => $normalTotal,
                'unique_price' => $uniquePrice,
            ]);

            $total = 0;
            $discount = 0;
            $allItems = array_merge($checkoutData['tickets'], $checkoutData['merchandise'] ?? []);

            foreach ($allItems as $item) {
                $product = Product::findOrFail($item['product_id']);
                $quantity = $item['quantity'];
                $pricePerUnit = $product->price;

                $itemDiscount = 0;

                if (! empty($checkoutData['applied_promo']) &&
                    $checkoutData['applied_promo']['event_id'] == $product->event_id) {

                    $isApplicable = ($product->type === 'ticket' && $checkoutData['applied_promo']['is_ticket'])
                        || ($product->type === 'merchandise' && $checkoutData['applied_promo']['is_merchandise']);

                    if ($isApplicable) {
                        if ($checkoutData['applied_promo']['type'] === 'percentage') {
                            $itemDiscount = ($pricePerUnit * ($checkoutData['applied_promo']['discount'] / 100)) * $quantity;
                        } else {
                            $itemDiscount = min($pricePerUnit, $checkoutData['applied_promo']['discount']) * $quantity;
                        }

                        Activity::create([
                            'user_id' => Auth::id(),
                            'action' => 'apply promo',
                            'model_type' => 'Order',
                            'model_id' => $order->id,
                        ]);
                    }
                }

                $priceBeforeDiscount = $pricePerUnit * $quantity;
                $subtotal = $priceBeforeDiscount - $itemDiscount;

                $total += $subtotal;
                $discount += $itemDiscount;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'total_price' => $subtotal,
                    'price_before_discount' => $priceBeforeDiscount,
                    'discount_amount' => $itemDiscount,
                ]);

                if ($product->type === 'ticket' && isset($validated['attendees'][$product->id])) {
                    (new ProcessAttendee)->handle(
                        $validated['attendees'][$product->id],
                        $quantity,
                        $order,
                        $product
                    );
                }
            }

            $order->update([
                'discount_amount' => $discount,
            ]);

            // HAPUS CACHE CHECKOUT DAN UNIQUE CODE
            Cache::forget('checkout:'.$checkoutData['token']);
            Cache::forget($cacheKey);
            Session::forget(['checkout_token', 'checkout_data']);

            Activity::create([
                'user_id' => Auth::id(),
                'action' => 'checkout',
                'model_type' => 'Order',
                'model_id' => $order->id,
            ]);

            DB::commit();

            return redirect()->route('orders.show', $order->id)->with('success', 'Order created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout failed: '.$e->getMessage());

            return back()->with('error', 'Checkout failed: '.$e->getMessage());
        }
    }

    // Hitung total normal dari checkout data (tanpa unique code)

    protected function calculateNormalTotal(array $checkoutData): int
    {
        $productIds = array_merge(
            array_column($checkoutData['tickets'], 'product_id'),
            array_column($checkoutData['merchandise'] ?? [], 'product_id')
        );

        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $subtotal = 0;

        // Hitung dari tickets
        foreach ($checkoutData['tickets'] as $ticket) {
            if (isset($products[$ticket['product_id']])) {
                $subtotal += $products[$ticket['product_id']]->price * $ticket['quantity'];
            }
        }

        // Hitung dari merchandise
        foreach ($checkoutData['merchandise'] ?? [] as $merch) {
            if (isset($products[$merch['product_id']])) {
                $subtotal += $products[$merch['product_id']]->price * $merch['quantity'];
            }
        }

        // Apply discount jika ada promo
        if (isset($checkoutData['applied_promo'])) {
            $promo = $checkoutData['applied_promo'];
            if ($promo['type'] === 'percentage') {
                $discount = $subtotal * ($promo['discount'] / 100);
            } else {
                $discount = $promo['discount'];
            }

            return $subtotal - $discount;
        }

        return $subtotal;
    }

    // Normalisasi nomor telepon Indonesia
    public function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone); // hapus semua non-digit
        if (str_starts_with($phone, '0')) {
            $phone = '62'.substr($phone, 1); // ganti 0 depan menjadi 62
        } elseif (! str_starts_with($phone, '62')) {
            $phone = '62'.$phone; // tambahkan 62 jika belum ada
        }

        return $phone;
    }
}
