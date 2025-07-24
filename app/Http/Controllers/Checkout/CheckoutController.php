<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $tickets = collect($request->tickets)->map(function ($quantity, $productId) {
            return ['product_id' => (int) $productId, 'quantity' => (int) $quantity];
        })->values()->all();

        $merchandise = collect($request->merchandise)->map(function ($quantity, $productId) {
            return ['product_id' => (int) $productId, 'quantity' => (int) $quantity];
        })->values()->all();

        // Generate token
        $token = Str::random(15);

        $checkoutData = [
            'token' => $token,
            'tickets' => $tickets,
            'merchandise' => $merchandise,
            'expires_at' => now()->addMinutes(15),
        ];

        session(['checkout_data' => $checkoutData]);

        // Redirect to checkout form with token
        return redirect()->route('checkout.form', ['token' => $token]);
    }

    public function showCheckoutForm($token)
    {
        $checkoutData = session('checkout_data');

        if (!$checkoutData || $checkoutData['token'] !== $token) {
            Log::error('Invalid or missing checkout data for token:', [$token]);
            return redirect()->route('home')->with('error', 'Sesi checkout telah kadaluarsa atau tidak valid.');
        }

        if (now()->gt($checkoutData['expires_at'])) {
            session()->forget('checkout_data');
            return redirect()->route('home')->with('error', 'Sesi checkout telah kadaluarsa.');
        }

        $productIds = array_merge(
            array_column($checkoutData['tickets'], 'product_id'),
            array_column($checkoutData['merchandise'], 'product_id')
        );

        $products = Product::with('event')
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $viewData = [
            'token' => $token,
            'tickets' => $checkoutData['tickets'],
            'merchandise' => $checkoutData['merchandise'],
            'products' => $products,
            'ticketCount' => array_sum(array_column($checkoutData['tickets'], 'quantity')),
            'checkoutData' => $checkoutData
        ];

        return view('checkout.form', $viewData);
    }


    public function submit(Request $request)
    {
        Log::debug('Checkout submit request:', $request->all());

        $request->validate([
            'token' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'attendees' => 'nullable|array',
            'attendees.*.name' => 'required_with:attendees|string|max:255',
            'attendees.*.email' => 'required_with:attendees|email|max:255',
        ]);

        // Retrieve checkout data from cache
        $checkoutData = Cache::get('checkout:' . $request->token);

        if (!$checkoutData) {
            return redirect()->route('home')->with('error', 'Sesi checkout telah kadaluarsa.');
        }

        DB::beginTransaction();

        try {
            // Create order
            $order = Order::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'status' => 'pending',
                'total_price' => 0,
            ]);

            $totalPrice = 0;
            $allItems = array_merge($checkoutData['tickets'], $checkoutData['merchandise']);

            foreach ($allItems as $item) {
                $product = Product::findOrFail($item['product_id']);
                $quantity = $item['quantity'];
                $subtotal = $product->price * $quantity;

                // Create order item
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'total_price' => $subtotal,
                ]);

                $totalPrice += $subtotal;

                // Handle attendees for tickets
                if ($product->type === 'ticket' && !empty($request->attendees)) {
                    $productAttendees = collect($request->attendees)
                        ->where('product_id', $product->id)
                        ->take($quantity);

                    foreach ($productAttendees as $attendeeData) {
                        Attendee::create([
                            'order_item_id' => $orderItem->id,
                            'name' => $attendeeData['name'],
                            'email' => $attendeeData['email'],
                            'ticket_code' => $product->event->event_code . '-' . strtoupper(Str::random(4)),
                        ]);
                    }
                }
            }

            // Update order total
            $order->update(['total_price' => $totalPrice]);

            // Clear checkout cache
            Cache::forget('checkout:' . $request->token);

            DB::commit();

            Log::info('Order created successfully:', ['order_id' => $order->id]);

            return redirect()->route('checkout.success', ['order' => $order->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout failed:', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }
}
