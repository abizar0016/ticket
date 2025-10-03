<?php

namespace App\Http\Controllers\SuperAdmin\Orders;

use App\Http\Controllers\SuperAdmin\SuperAdminBaseController;
use App\Models\Event;
use App\Models\Order;

class SuperAdminOrdersController extends SuperAdminBaseController
{
    public function index()
    {
        $viewData = $this->getViewData('orders');
        $orders = Order::with(['event', 'items.product'])
            ->latest()
            ->paginate(10);

        return view('layouts.superAdmin.index', array_merge($viewData, [
            'orders' => $orders
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
