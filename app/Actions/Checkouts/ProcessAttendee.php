<?php

namespace App\Actions\Checkouts;

use App\Models\Attendee;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Str;

class ProcessAttendee
{
    public function handle(array $attendees, int $quantity, Order $order, Product $product)
    {
        foreach (array_slice($attendees, 0, $quantity) as $attendee) {
            Attendee::create([
                'name' => $attendee['name'],
                'email' => $attendee['email'],
                'phone' => $attendee['phone'],
                'order_id' => $order->id,
                'product_id' => $product->id,
                'event_id' => $product->event_id,
                'ticket_code' => $product->event->event_code . '-' . Str::upper(Str::random(6)),
                'status' => 'pending',
            ]);
        }
    }
}
