<?php

namespace App\Actions\Checkouts;

use App\Models\Attendee;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ProcessAttendee
{
    public function handle(array $attendees, int $quantity, Order $order, Product $product)
    {
        $method = 'AES-256-CBC';
        $key = env('QR_ENCRYPTION_KEY');

        foreach (array_slice($attendees, 0, $quantity) as $attendeeData) {
            $attendee = Attendee::create([
                'name' => $attendeeData['name'],
                'email' => $attendeeData['email'],
                'phone' => $this->normalizePhone($attendeeData['phone']),
                'order_id' => $order->id,
                'product_id' => $product->id,
                'event_id' => $product->event_id,
                'ticket_code' => $product->event->event_code . '-' . Str::upper(Str::random(6)),
                'status' => 'pending',
                'identity_type' => $attendeeData['identity_type'] ?? null,
                'identity_number' => $attendeeData['identity_number'] ?? null,
            ]);

            // 🧩 Generate QR code sekali saja
            try {
                $dataToEncrypt = $attendee->ticket_code;
                $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
                $encryptedData = openssl_encrypt($dataToEncrypt, $method, $key, 0, $iv);
                $finalEncryptedOutput = base64_encode($encryptedData . '::' . base64_encode($iv));

                $urlQrCode = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&ecc=L&qzone=1&data=' .
                    urlencode($finalEncryptedOutput);

                // 💾 Simpan ke database biar tidak regenerate di view
                $attendee->update(['url_qrcode' => $urlQrCode]);

                Log::info('✅ Generated QR code for attendee', [
                    'attendee_id' => $attendee->id,
                    'ticket_code' => $attendee->ticket_code,
                ]);
            } catch (\Exception $e) {
                Log::error('❌ Failed to generate QR code', [
                    'attendee_id' => $attendee->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    // Fungsi untuk normalisasi nomor telepon Indonesia
    protected function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (!str_starts_with($phone, '62')) {
            $phone = '62' . $phone;
        }
        return $phone;
    }
}
