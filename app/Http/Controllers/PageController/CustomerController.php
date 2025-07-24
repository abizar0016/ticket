<?php

namespace App\Http\Controllers\PageController;

use App\Models\Event;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Attendee;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $users = Auth::user();

        $events = Event::with([
            'products' => function ($query) {
                $query->where('sale_start_date', '<=', now())
                    ->where('sale_end_date', '>=', now());
            },
            'location'
        ])
            ->where('end_date', '>', now())
            ->where('status', '!=', 'draft')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('index', compact('users', 'events'));
    }

    public function eventShow($id)
    {
        $event = Event::with([
            'products' => function ($query) {
                $query->where('sale_start_date', '<=', now())
                    ->where('sale_end_date', '>=', now());
            },
            'location'
        ])
            ->where('end_date', '>', now())
            ->where('status', '!=', 'draft')
            ->where('id', $id)
            ->firstOrFail();

        $products = Product::where('event_id', $event->id)
            ->where('sale_start_date', '<=', now())
            ->where('sale_end_date', '>=', now())
            ->get();

        return view('eventShow.index', [
            'event' => $event,
            'products' => $products,
            'cart' => [
                'items' => [],
                'total' => 0
            ]
        ]);
    }

    public function submitCheckout(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'attendees' => 'nullable|array',
            'attendees.*.name' => 'required_with:attendees|string',
            'attendees.*.email' => 'required_with:attendees|email',
            'cart_data' => 'required|string',
        ]);

        $cart = json_decode($data['cart_data'], true);
        if (empty($cart)) {
            return redirect('/')->with('error', 'Keranjang kosong.');
        }

        // 🔍 Validasi stok produk terlebih dahulu
        foreach ($cart as $item) {
            $product = Product::find($item['productId']);
            if (!$product) {
                return redirect()->back()->with('error', 'Produk tidak ditemukan.');
            }
            if ($product->quantity < $item['quantity']) {
                return redirect()->back()->with('error', 'Stok tidak cukup untuk produk: ' . $product->title);
            }
        }

        $order = Order::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'total_price' => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
            'status' => 'pending',
        ]);

        $attendeeIndex = 0;
        $createdAttendees = [];

        foreach ($cart as $item) {
            $itemTotal = $item['price'] * $item['quantity'];

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['productId'],
                'promo_code_id' => null,
                'quantity' => $item['quantity'],
                'total_price' => $itemTotal,
                'price_before_discount' => $item['price'],
            ]);

            $product = Product::find($item['productId']);
            if ($product) {
                $product->decrement('quantity', $item['quantity']);
            }

            if (isset($item['type']) && strtolower($item['type']) === 'ticket') {
                for ($i = 0; $i < $item['quantity']; $i++) {
                    if (!isset($data['attendees'][$attendeeIndex]))
                        continue;

                    $attendeeData = $data['attendees'][$attendeeIndex];
                    $ticketCode = $product->event->event_code . '-' . strtoupper(Str::random(4));

                    $attendee = Attendee::create([
                        'name' => $attendeeData['name'],
                        'email' => $attendeeData['email'],
                        'order_id' => $order->id,
                        'product_id' => $item['productId'],
                        'event_id' => $item['eventId'],
                        'ticket_code' => $ticketCode,
                        'status' => 'pending',
                    ]);

                    $createdAttendees[] = $attendee;
                    $attendeeIndex++;
                }
            }
        }

        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Order berhasil dibuat.');
    }
}
