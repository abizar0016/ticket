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
                'phone' => $this->normalizePhone($attendee['phone']),
                'order_id' => $order->id,
                'product_id' => $product->id,
                'event_id' => $product->event_id,
                'ticket_code' => $product->event->event_code.'-'.Str::upper(Str::random(6)),
                'status' => 'pending',
                'identity_type' => $attendee['identity_type'] ?? null,
                'identity_number' => $attendee['identity_number'] ?? null,
            ]);
        }
    }

    // Fungsi untuk normalisasi nomor telepon Indonesia
    protected function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone); // hapus semua non-digit
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1); // ganti 0 depan menjadi 62
        } elseif (!str_starts_with($phone, '62')) {
            $phone = '62' . $phone; // tambahkan 62 jika belum ada
        }
        return $phone;
    }
}
