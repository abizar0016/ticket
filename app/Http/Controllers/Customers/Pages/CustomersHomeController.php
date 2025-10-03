<?php

namespace App\Http\Controllers\Customers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CustomersHomeController extends Controller
{
    public function index()
    {

        $users = Auth::user();
        $search = request('search');

        $events = Event::with([
            'products' => function ($query) {
                $query->where('sale_start_date', '<=', now())
                    ->where('sale_end_date', '>=', now());
            },
        ])
            ->where('end_date', '>', now())
            ->where('status', '!=', 'draft')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', '%'.$search.'%');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('layouts.customers.index', compact('users', 'events'));
    }

    public function eventShow($id)
    {
        $event = Event::with([
            'products' => function ($query) {
                $query->where('sale_start_date', '<=', now())
                    ->where('sale_end_date', '>=', now());
            },
        ])
            ->where('end_date', '>', now())
            ->where('status', '!=', 'draft')
            ->where('id', $id)
            ->firstOrFail();

        return view('pages.Customers.eventShow.index', [
            'event' => $event,
            'products' => $event->products,
            'cart' => [
                'items' => [],
                'total' => 0,
            ],
        ]);
    }

    public function showCheckoutForm($token)
    {
        $checkoutData = session('checkout_data');

        if (! $checkoutData || $checkoutData['token'] !== $token) {
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
            'checkoutData' => $checkoutData,
        ];

        return view('pages.Customers.checkout.form', $viewData);
    }
}
