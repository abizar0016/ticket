<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrdersController extends AdminBaseController
{
    public function index($id)
    {
        $event = $this->getEvent($id);
        $viewData = $this->getViewData('orders', $event);
        $search = request('search');

        $ordersQuery = Order::whereHas('items.product', fn($q) => $q->where('event_id', $event->id))
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            });

        $orders = $ordersQuery->orderByDesc('created_at')->paginate(10);
        $totalOrders = $orders->total();


        return view('Admin.eventDashboard.index', array_merge($viewData, [
            'orders' => $orders,
            'paidOrdersCount' => Order::whereHas('items.product', fn($q) => $q->where('event_id', $event->id))
                ->where('status', 'paid')->count(),
            'pendingOrdersCount' => Order::whereHas('items.product', fn($q) => $q->where('event_id', $event->id))
                ->where('status', 'pending')->count(),
            'paidPercentage' => $totalOrders > 0 ? round((Order::whereHas('items.product', fn($q) => $q->where('event_id', $event->id))
                ->where('status', 'paid')->count() / $totalOrders) * 100) : 0,
            'pendingPercentage' => $totalOrders > 0
                ? round((Order::whereHas('items.product', fn($q) => $q->where('event_id', $event->id))
                    ->where('status', 'pending')->count() / $totalOrders) * 100)
                : 0,

            'totalRevenue' => Order::whereHas('items.product', fn($q) => $q->where('event_id', $event->id))
                ->where('status', 'paid')->sum('total_price'),
            'search' => $search,
        ]));
    }

    public function show($eventId, $orderId)
    {
        $order = Order::with(['items.product.event', 'attendees'])
            ->where('id', $orderId)
            ->whereHas('items.product', fn($q) => $q->where('event_id', $eventId))
            ->firstOrFail();

        $event = $order->items->first()->product->event;

        $method = 'AES-256-CBC';
        $key = env('QR_ENCRYPTION_KEY');

        foreach ($order->attendees as $attendee) {
            $data = json_encode([
                'nama' => $attendee->name,
                'kode' => $attendee->code,
            ]);

            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
            $encrypted_data = openssl_encrypt($data, $method, $key, 0, $iv);
            $final_encrypted_output = base64_encode($encrypted_data . '::' . $iv);

            $url_qrcode = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&ecc=L&qzone=1&data=' . urlencode($final_encrypted_output);

            $attendee->url_qrcode = $url_qrcode;
            
        }

        $viewData = $this->getViewData('order-show', $event);

        return view('Admin.eventDashboard.index', array_merge($viewData, [
            'order' => $order,
        ]));
    }
}
