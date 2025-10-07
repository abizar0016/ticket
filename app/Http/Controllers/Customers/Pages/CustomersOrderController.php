<?php

namespace App\Http\Controllers\Customers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

        $firstProduct = $order->items->first()?->product;
        $event = $firstProduct?->event;

        $method = 'AES-256-CBC';
        $key = env('QR_ENCRYPTION_KEY');

        foreach ($order->attendees as $attendee) {
            $dataToEncrypt = $attendee->ticket_code;
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
            $encrypted_data = openssl_encrypt($dataToEncrypt, $method, $key, 0, $iv);

            $final_encrypted_output = base64_encode($encrypted_data.'::'.base64_encode($iv));

            $url_qrcode = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&ecc=L&qzone=1&data='.
                urlencode($final_encrypted_output);

            $attendee->url_qrcode = $url_qrcode;

            Log::debug('Generated QR code for attendee', [
                'attendee_id' => $attendee->id,
                'ticket_code' => $attendee->ticket_code,
                'encrypted_data' => $encrypted_data,
                'iv_length' => strlen($iv),
                'final_output' => $final_encrypted_output,
            ]);
        }

        return view('pages.Customers.orders.show', compact('order', 'event'));
    }
}
