<?php

namespace App\Actions\Checkouts;

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
use App\Actions\Checkouts\Concerns\HandlesCheckoutData;

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

            $order = Order::create([
                'user_id' => Auth::id(),
                'event_id' => $eventId,
                'promo_id' => $promoId,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'status' => 'pending',
                'total_price' => 0,
                'discount_amount' => 0,
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
                'total_price' => $total,
                'discount_amount' => $discount,
            ]);

            Cache::forget('checkout:'.$checkoutData['token']);
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
}
