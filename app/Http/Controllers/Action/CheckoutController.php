<?php

namespace App\Http\Controllers\Action;

use App\Http\Controllers\Controller;
use App\Models\{Attendee, Order, OrderItem, Product, PromoCode};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Cache, DB, Log, Session};
use Illuminate\Support\Str;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    protected function generateCheckoutToken(): string
    {
        do {
            $token = 'chk_' . Str::random(20);
        } while (Cache::has('checkout:' . $token));

        return $token;
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'tickets' => 'required|array',
            'tickets.*' => 'integer|min:1',
            'merchandise' => 'nullable|array',
            'merchandise.*' => 'nullable|integer',
        ]);

        $token = $this->generateCheckoutToken();
        $expiresAt = now()->addMinutes(30);

        $checkoutData = [
            'token' => $token,
            'tickets' => collect($validated['tickets'])
                ->map(fn($qty, $id) => ['product_id' => (int)$id, 'quantity' => (int)$qty])
                ->values()
                ->all(),
            'merchandise' => collect($validated['merchandise'] ?? [])
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

    protected function getCheckoutData(string $token): ?array
    {
        $data = Cache::get('checkout:' . $token);

        if (!$data && Session::get('checkout_token') === $token) {
            $data = Session::get('checkout_data');
        }

        if (!$data || !isset($data['token']) || $data['token'] !== $token) {
            return null;
        }

        if (isset($data['expires_at']) && Carbon::parse($data['expires_at'])->isPast()) {
            return null;
        }

        return $data;
    }

    public function showCheckoutForm(Request $request, string $token)
    {
        $checkoutData = $this->getCheckoutData($token);

        if (!$checkoutData) {
            return redirect()->route('home')->with('error', 'Checkout session expired');
        }

        $productIds = array_merge(
            array_column($checkoutData['tickets'], 'product_id'),
            array_column($checkoutData['merchandise'] ?? [], 'product_id')
        );

        return view('checkout.form', [
            'checkoutData' => $checkoutData,
            'products' => Product::with('event')
                ->whereIn('id', $productIds)
                ->get()
                ->keyBy('id'),
            'tickets' => $checkoutData['tickets'],
        ]);
    }

    public function applyPromo(Request $request)
    {
        $request->validate([
            'promo_code' => 'required|string|max:50',
            'token'      => 'required|string'
        ]);

        $token = $request->input('token');
        $checkoutData = $this->getCheckoutData($token);

        if (!$checkoutData || !isset($checkoutData['token']) || $checkoutData['token'] !== $token) {
            return response()->json(['success' => false, 'message' => 'Invalid checkout session'], 400);
        }

        // Ambil promo code sesuai kode
        $promo = PromoCode::where('code', $request->input('promo_code'))
            ->where(function ($q) {
                $q->where('max_uses', '>', 0)->orWhereNull('max_uses');
            })
            ->first();

        if (!$promo) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired promo code'], 400);
        }

        // Cek kuota penggunaan
        $usedCount = Order::where('promo_id', $promo->id)->count();
        if (!is_null($promo->max_uses) && $usedCount >= $promo->max_uses) {
            return response()->json(['success' => false, 'message' => 'Promo code has exhausted its uses'], 400);
        }

        // Ambil semua product_id dari checkout
        $productIds = array_merge(
            array_column($checkoutData['tickets'] ?? [], 'product_id'),
            array_column($checkoutData['merchandise'] ?? [], 'product_id')
        );

        // Pastikan semua product yang dibeli berasal dari event yang sama dengan promo
        $productsEventIds = Product::whereIn('id', $productIds)->pluck('event_id')->unique();
        if ($productsEventIds->count() > 1 || !$productsEventIds->contains($promo->event_id)) {
            return response()->json(['success' => false, 'message' => 'Promo code not valid for this event'], 400);
        }

        // Simpan promo ke checkout data
        $checkoutData['applied_promo'] = [
            'id'        => $promo->id,
            'event_id'  => $promo->event_id,
            'discount'  => $promo->discount,
            'type'      => $promo->type,
            'code'      => $promo->code
        ];

        Cache::put('checkout:' . $token, $checkoutData, Carbon::parse($checkoutData['expires_at']));
        Session::put('checkout_data', $checkoutData);

        return response()->json([
            'success' => true,
            'message' => 'Promo code applied successfully',
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

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'token'                => 'required|string',
            'name'                 => 'required|string|max:255',
            'email'                => 'required|email|max:255',
            'attendees'            => 'nullable|array',
            'attendees.*.*.name'   => 'required_with:attendees|string|max:255',
            'attendees.*.*.email'  => 'required_with:attendees|email|max:255',
        ]);

        $checkoutData = $this->getCheckoutData($validated['token']);
        if (!$checkoutData) {
            return back()->with('error', 'Invalid checkout session');
        }

        DB::beginTransaction();
        try {
            $promoId = $checkoutData['applied_promo']['id'] ?? null;

            // Ambil event_id dari produk pertama (ticket / merchandise)
            $firstProductId = $checkoutData['tickets'][0]['product_id'] ?? ($checkoutData['merchandise'][0]['product_id'] ?? null);
            if (!$firstProductId) {
                throw new \Exception('No products found in checkout');
            }
            $eventId = Product::findOrFail($firstProductId)->event_id;

            $order = Order::create([
                'user_id'         => Auth::id(),
                'event_id'        => $eventId,
                'promo_id'        => $promoId,
                'name'            => $validated['name'],
                'email'           => $validated['email'],
                'status'          => 'pending',
                'total_price'     => 0,
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

                // Diskon per tiket / merchandise dalam event yang sama
                if (!empty($checkoutData['applied_promo']) && $checkoutData['applied_promo']['event_id'] == $product->event_id) {
                    if ($checkoutData['applied_promo']['type'] === 'percentage') {
                        // Diskon = (harga satuan × persen) × jumlah
                        $itemDiscount = ($pricePerUnit * ($checkoutData['applied_promo']['discount'] / 100)) * $quantity;
                    } else {
                        // Diskon fixed per item × jumlah
                        $itemDiscount = min($pricePerUnit, $checkoutData['applied_promo']['discount']) * $quantity;
                    }
                }

                $priceBeforeDiscount = $pricePerUnit * $quantity;
                $subtotal = $priceBeforeDiscount - $itemDiscount;

                $total += $subtotal;
                $discount += $itemDiscount;

                OrderItem::create([
                    'order_id'              => $order->id,
                    'product_id'            => $product->id,
                    'quantity'              => $quantity,
                    'total_price'           => $subtotal,
                    'price_before_discount' => $priceBeforeDiscount,
                    'discount_amount'       => $itemDiscount,
                ]);

                // Simpan data peserta jika tipe produk ticket
                if ($product->type === 'ticket' && isset($validated['attendees'][$product->id])) {
                    $this->processAttendees(
                        $validated['attendees'][$product->id],
                        $quantity,
                        $order,
                        $product
                    );
                }
            }

            // Update total dan diskon order
            $order->update([
                'total_price'     => $total,
                'discount_amount' => $discount
            ]);

            // Bersihkan cache dan session
            Cache::forget('checkout:' . $checkoutData['token']);
            Session::forget(['checkout_token', 'checkout_data']);

            DB::commit();

            return redirect()->route('orders.show', $order->id)->with('success', 'Order created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout failed: ' . $e->getMessage());
            return back()->with('error', 'Checkout failed: ' . $e->getMessage());
        }
    }


    protected function processAttendees(array $attendees, int $quantity, Order $order, Product $product)
    {
        foreach (array_slice($attendees, 0, $quantity) as $attendee) {
            Attendee::create([
                'name' => $attendee['name'],
                'email' => $attendee['email'],
                'order_id' => $order->id,
                'product_id' => $product->id,
                'event_id' => $product->event_id,
                'ticket_code' => $product->event->event_code . '-' . Str::upper(Str::random(6)),
                'status' => 'pending',
            ]);
        }
    }
}
