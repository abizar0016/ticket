<?php

namespace App\Actions\Orders;

use App\Mail\OrderPaidConfirmationMail;
use App\Models\Activity;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MarkAsPaid
{
    public function handle(int $id): JsonResponse
    {
        $order = Order::with(['items.product.event', 'attendees'])->findOrFail($id);

        if ($order->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Order is not in pending status.',
            ], 400);
        }

        // ===================================================
        // 1. Kurangi stok produk
        // ===================================================
        foreach ($order->items as $item) {
            if ($item->product && $item->product->quantity !== null) {
                $item->product->decrement('quantity', $item->quantity);
            }
        }

        // ===================================================
        // 2. Update status attendee & order
        // ===================================================
        foreach ($order->attendees as $attendee) {
            $attendee->update(['status' => 'active']);
        }

        $order->update(['status' => 'paid']);

        // ===================================================
        // 3. Kirim notifikasi utama ke pemesan
        // ===================================================
        $this->sendEmailAndWhatsApp(
            $order->email,
            $order->phone,
            $order,
            $order->name ?? 'Pelanggan'
        );

        // ===================================================
        // 4. Kirim notifikasi ke semua attendee
        // ===================================================
        $sentContacts = [];

        // Tambahkan kontak pemesan ke daftar agar tidak dikirim dua kali
        if ($order->email) {
            $sentContacts[] = $order->email;
        }
        if ($order->phone) {
            $sentContacts[] = $order->phone;
        }

        foreach ($order->attendees as $attendee) {
            $contactKey = $attendee->email ?: $attendee->phone;

            // Skip jika email/phone sudah pernah dikirim
            if (in_array($contactKey, $sentContacts, true)) {
                continue;
            }

            $this->sendEmailAndWhatsApp(
                $attendee->email,
                $attendee->phone,
                $order,
                $attendee->name
            );

            // Simpan email & phone agar tidak dikirim ulang
            if ($attendee->email) {
                $sentContacts[] = $attendee->email;
            }
            if ($attendee->phone) {
                $sentContacts[] = $attendee->phone;
            }
        }
        $sentContacts[] = $contactKey;

        Activity::create([
            'user_id'    => Auth::id(),
            'action'     => 'Mark as Paid',
            'model_type' => 'Order',
            'model_id'   => $order->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order marked as paid and notifications sent.',
        ]);
    }

    // ===================================================
    // ✉️ Helper: Kirim Email dan WhatsApp
    // ===================================================
    protected function sendEmailAndWhatsApp(?string $email, ?string $phone, Order $order, string $recipientName): void
    {
        // Kirim email
        if ($email) {
            try {
                Mail::to($email)->send(new OrderPaidConfirmationMail($order, $recipientName));
                Log::info("✅ Email sent to {$email}");
            } catch (\Throwable $e) {
                Log::error("❌ Failed sending email to {$email}: ".$e->getMessage());
            }
        }

        // Kirim WhatsApp
        if ($phone) {
            $message = "Halo {$recipientName}, pesanan Anda dengan ID #{$order->id} telah dikonfirmasi.";
            $this->sendWhatsApp($phone, $message);
        }
    }

    // ===================================================
    // 💬 Helper: Kirim WhatsApp via Fonnte API
    // ===================================================
    protected function sendWhatsApp(string $phone, string $message): void
    {
        $normalized = $this->normalizePhone($phone);
        $waLink = "https://wa.me/{$normalized}?text=".urlencode($message);

        Log::info("📱 WhatsApp link created: {$waLink}");

        try {
            $token = env('FONNTE_TOKEN');
            if ($token) {
                $response = Http::withHeaders([
                    'Authorization' => $token,
                ])->asForm()->post('https://api.fonnte.com/send', [
                    'target' => $normalized,
                    'message' => $message,
                ]);

                if ($response->successful()) {
                    Log::info("✅ WhatsApp sent via Fonnte to {$normalized}");
                } else {
                    Log::warning("⚠️ Fonnte response error for {$normalized}: ".$response->body());
                }
            } else {
                Log::warning('⚠️ Fonnte token not set — message not sent via API.');
            }
        } catch (\Throwable $th) {
            Log::error("❌ Failed sending WhatsApp via API to {$normalized}: ".$th->getMessage());
        }
    }

    // ===================================================
    // ☎️ Helper: Normalisasi Nomor Telepon
    // ===================================================
    protected function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62'.substr($phone, 1);
        }

        return $phone;
    }
}
