<?php

namespace App\Http\Controllers\Customers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomersOrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $orders = $user->orders()
            ->with('items.product')
            ->latest()
            ->paginate(10);

        $orders->getCollection()->transform(function ($order) {
            $uniquePrice = $order->unique_price ?? 0;

            $order->uniqueAmount = $order->total_price + $uniquePrice;

            return $order;
        });

        return view('pages.Customers.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $user = Auth::user();

        $order = $user->orders()
            ->with(['items.product.event', 'attendees'])
            ->findOrFail($id);

        $uniquePrice = $order->unique_price ?? 0;
        $order->uniqueAmount = $order->total_price + $uniquePrice;

        $attendees = $order->attendees;

        $firstProduct = $order->items->first()?->product;
        $event = $firstProduct?->event;

        return view('pages.Customers.orders.show', compact('order', 'event', 'attendees'));
    }
}
