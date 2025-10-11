<?php

namespace App\Actions\Orders;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\{Log, Mail, Http};

class MarkAsPaid
{
    public function handle(int $id): JsonResponse
    {
        $order = Order::with(['items.product', 'attendees'])->findOrFail($id);

        if ($order->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Order is not in pending status.',
            ], 400);
        }

        // ===================================================
        // 🔹 1. Kurangi stok produk
        // ===================================================
        foreach ($order->items as $item) {
            if ($item->product && $item->product->quantity !== null) {
                $item->product->decrement('quantity', $item->quantity);
            }
        }

        // ===================================================
        // 🔹 2. Update status attendee & order
        // ===================================================
        foreach ($order->attendees as $attendee) {
            $attendee->update(['status' => 'active']);
        }

        $order->update(['status' => 'paid']);

        // ===================================================
        // 🔹 3. Siapkan pesan utama
        // ===================================================
        $message = "Halo, pesanan Anda dengan ID #{$order->id} telah dikonfirmasi.";
        $whatsappLinks = [];

        // ===================================================
        // 🔹 4. Kirim ke email & WhatsApp pemesan utama
        // ===================================================
        $this->sendEmail($order->email, 'Konfirmasi Pesanan Anda', $message);

        if ($order->phone) {
            $waLink = $this->sendWhatsApp($order->phone, $message);
            $whatsappLinks[] = [
                'recipient' => $order->phone,
                'link' => $waLink,
            ];
        }

        // ===================================================
        // 🔹 5. Kirim ke semua attendee
        // ===================================================
        foreach ($order->attendees as $attendee) {
            $messageAttendee = "Halo {$attendee->name}, pesanan Anda dengan ID #{$order->id} telah dikonfirmasi.";

            $this->sendEmail($attendee->email, 'Konfirmasi Pesanan Anda', $messageAttendee);

            if ($attendee->phone) {
                $waLink = $this->sendWhatsApp($attendee->phone, $messageAttendee);
                $whatsappLinks[] = [
                    'recipient' => $attendee->phone,
                    'link' => $waLink,
                ];
            }
        }

        // ===================================================
        // 🔹 6. Response
        // ===================================================
        return response()->json([
            'success' => true,
            'message' => 'Order marked as paid and notifications sent.',
            'whatsapp_links' => $whatsappLinks,
        ]);
    }

    // ===================================================
    // ✉️ Helper: Kirim Email
    // ===================================================
    protected function sendEmail(?string $to, string $subject, string $message): void
    {
        if (!$to) return;

        try {
            Mail::raw($message, function ($mail) use ($to, $subject) {
                $mail->to($to)->subject($subject);
            });
            Log::info("✅ Email sent to {$to}");
        } catch (\Throwable $e) {
            Log::error("❌ Failed sending email to {$to}: " . $e->getMessage());
        }
    }

    // ===================================================
    // 💬 Helper: Kirim WhatsApp (via API Fonnte)
    // ===================================================
    protected function sendWhatsApp(string $phone, string $message): string
    {
        $normalized = $this->normalizePhone($phone);
        $waLink = 'https://wa.me/' . $normalized . '?text=' . urlencode($message);

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
                    Log::warning("⚠️ Fonnte response error for {$normalized}: " . $response->body());
                }
            } else {
                Log::warning("⚠️ Fonnte token not set — message not sent via API.");
            }
        } catch (\Throwable $th) {
            Log::error("❌ Failed sending WhatsApp via API to {$normalized}: " . $th->getMessage());
        }

        return $waLink;
    }

    // ===================================================
    // ☎️ Helper: Normalisasi Nomor Telepon
    // ===================================================
    protected function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }
        return $phone;
    }
}
