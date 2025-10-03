<?php

namespace App\Http\Controllers\SuperAdmin\Events;

use App\Models\Event;
use App\Models\Order;

class SuperAdminEventsOrdersController extends SuperAdminEventsBaseController
{
    public function index($eventId)
    {
        $events = Event::with(['user', 'organization'])
            ->findOrFail($eventId);

        $viewData = $this->getEventsViewData('orders', $eventId);

        $search = request('search');

        $ordersQuery = Order::whereHas('items.product', function ($q) use ($events) {
            $q->where('event_id', $events->id);
        })
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });

        $orders = $ordersQuery->orderByDesc('created_at')->paginate(10);
        $totalOrders = $orders->total();

        $paidOrdersCount = Order::whereHas('items.product', fn ($q) => $q->where('event_id', $events->id))
            ->where('status', 'paid')->count();

        $pendingOrdersCount = Order::whereHas('items.product', fn ($q) => $q->where('event_id', $events->id))
            ->where('status', 'pending')->count();

        $totalOrders = $paidOrdersCount + $pendingOrdersCount;

        $paidPercentage = $totalOrders > 0 ? round(($paidOrdersCount / $totalOrders) * 100) : 0;
        $pendingPercentage = $totalOrders > 0 ? round(($pendingOrdersCount / $totalOrders) * 100) : 0;

        $totalRevenue = Order::whereHas('items.product', fn ($q) => $q->where('event_id', $events->id))
            ->where('status', 'paid')->sum('total_price');

        return view('layouts.superAdmin.index', array_merge($viewData, [
            'events' => $events,
            'orders' => $orders,
            'paidOrdersCount' => $paidOrdersCount,
            'pendingOrdersCount' => $pendingOrdersCount,
            'paidPercentage' => $paidPercentage,
            'pendingPercentage' => $pendingPercentage,
            'totalRevenue' => $totalRevenue,
            'search' => $search,
        ]));
    }

    public function show($eventId, $orderId)
    {

        $events = Event::with(['user', 'organization'])
            ->findOrFail($eventId);

        $viewData = $this->getEventsViewData('orders-show', $eventId);

        $order = Order::with(['items.product.event', 'attendees'])
            ->where('id', $orderId)
            ->whereHas('items.product', fn ($q) => $q->where('event_id', $eventId))
            ->firstOrFail();

        $method = 'AES-256-CBC';
        $key = env('QR_ENCRYPTION_KEY');

        foreach ($order->attendees as $attendee) {
            $data = json_encode([
                'nama' => $attendee->name,
                'kode' => $attendee->code,
            ]);

            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
            $encrypted_data = openssl_encrypt($data, $method, $key, 0, $iv);
            $final_encrypted_output = base64_encode($encrypted_data.'::'.$iv);

            $url_qrcode = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&ecc=L&qzone=1&data='.urlencode($final_encrypted_output);

            $attendee->url_qrcode = $url_qrcode;

        }

        return view('layouts.superAdmin.index', array_merge($viewData, [
            'events' => $events,
            'order' => $order,
        ]));
    }
}
