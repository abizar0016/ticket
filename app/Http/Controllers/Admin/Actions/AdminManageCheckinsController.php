<?php

namespace App\Http\Controllers\Admin\Actions;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use App\Models\Checkin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminManageCheckinsController extends Controller
{
    public function processCheckin(Request $request)
    {
        $request->validate([
            'ticket_code' => 'required|string'
        ]);

        try {
            $decryptedCode = $this->decryptTicketCode($request->ticket_code);
            Log::debug('Decrypted ticket code:', ['code' => $decryptedCode]);

            // Cari attendee berdasarkan kode tiket
            $attendee = Attendee::with(['event', 'order', 'product'])
                ->whereRaw('LOWER(TRIM(ticket_code)) = ?', [strtolower(trim($decryptedCode))])
                ->first();

            if (!$attendee) {
                Log::error('Attendee not found', [
                    'decrypted_code' => $decryptedCode,
                    'sample_ticket_from_db' => Attendee::first()?->ticket_code
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Tiket tidak valid atau tidak ditemukan.'
                ], 404);
            }

            if ($attendee->status === 'pending' && $attendee->order->status !== 'paid') {
                Log::warning('Order belum dibayar', [
                    'attendee_id' => $attendee->id,
                    'order_status' => $attendee->order?->status,
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Tiket ini belum dibayar dan tidak bisa digunakan untuk check-in.'
                ], 403);
            }

            $existingCheckin = Checkin::where('attendee_id', $attendee->id)->first();
            if ($existingCheckin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tiket ini sudah check-in sebelumnya pada ' .
                        $existingCheckin->created_at->format('d/m/Y H:i'),
                    'attendee' => $attendee,
                    'previous_checkin' => $existingCheckin
                ], 409);
            }

            $checkin = Checkin::create([
                'event_id' => $attendee->event_id,
                'attendee_id' => $attendee->id,
                'product_id' => $attendee->product_id,
                'order_id' => $attendee->order_id,
                'ip_address' => $request->ip(),
            ]);

            $attendee->update(['status' => 'used']);

            Log::info('Checkin successful', [
                'attendee_id' => $attendee->id,
                'checkin_id' => $checkin->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Check-in berhasil!',
                'attendee' => $attendee,
                'event' => $attendee->event,
                'checkin_time' => $checkin->created_at->format('d/m/Y H:i')
            ]);
        } catch (\Exception $e) {
            Log::error('Checkin error: ' . $e->getMessage(), [
                'exception' => $e,
                'ticket_code' => $request->ticket_code
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat melakukan check-in: ' . $e->getMessage()
            ], 500);
        }
    }

    public function processManualCheckin(Request $request)
    {
        $request->validate([
            'ticket_code' => 'required|string'
        ]);

        try {
            // Cari attendee langsung pakai ticket_code tanpa decrypt
            $attendee = Attendee::with(['event', 'order', 'product'])
                ->whereRaw('LOWER(TRIM(ticket_code)) = ?', [strtolower(trim($request->ticket_code))])
                ->firstOrFail();

            // Cek kalau belum dibayar
            if ($attendee->status === 'pending' && $attendee->order->status !== 'paid') {
                return response()->json([
                    'success' => false,
                    'message' => 'Tiket ini belum dibayar dan tidak bisa digunakan untuk check-in.',
                    'manual_checkin' => true
                ], 403);
            }

            // Cek kalau sudah pernah check-in
            if ($existingCheckin = Checkin::where('attendee_id', $attendee->id)->first()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tiket ini sudah check-in sebelumnya pada ' .
                        $existingCheckin->created_at->format('d/m/Y H:i'),
                    'manual_checkin' => true
                ], 409);
            }

            // Buat check-in baru
            $checkin = Checkin::create([
                'event_id' => $attendee->event_id,
                'attendee_id' => $attendee->id,
                'product_id' => $attendee->product_id,
                'order_id' => $attendee->order_id,
                'ip_address' => $request->ip(),
            ]);

            // Update status attendee jadi used
            $attendee->update(['status' => 'used']);

            Log::info('Manual check-in successful', [
                'attendee_id' => $attendee->id,
                'checkin_id' => $checkin->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Check-in manual berhasil!',
                'attendee' => $attendee->load('event', 'order', 'product'),
                'event' => $attendee->event,
                'checkin_time' => $checkin->created_at->format('d/m/Y H:i'),
                'manual_checkin' => true
            ]);

        } catch (\Exception $e) {
            Log::error('Manual check-in failed: ' . $e->getMessage());

            $statusCode = 500;
            $message = $e->getMessage();

            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                $statusCode = 404;
                $message = 'Tiket tidak valid atau tidak ditemukan.';
            }

            return response()->json([
                'success' => false,
                'message' => $message,
                'manual_checkin' => true
            ], $statusCode);
        }
    }

    private function decryptTicketCode($encryptedCode)
    {
        Log::info('Starting ticket code decryption');
        Log::debug('Encrypted code received:', ['code' => $encryptedCode]);

        $decoded = base64_decode($encryptedCode);
        Log::debug('Base64 decoded:', ['decoded' => $decoded]);

        $parts = explode('::', $decoded, 2);
        Log::debug('Exploded parts:', ['parts' => $parts, 'count' => count($parts)]);

        if (count($parts) !== 2) {
            Log::error('Invalid ticket code format - expected 2 parts');
            throw new \Exception('Format kode tiket tidak valid');
        }

        $encryptedData = $parts[0];
        $iv = base64_decode($parts[1]);
        Log::debug('Extracted components:', [
            'encryptedData' => $encryptedData,
            'iv_length' => strlen($iv),
            'iv_hex' => bin2hex($iv)
        ]);

        $key = env('QR_ENCRYPTION_KEY');
        Log::debug('Encryption key from env:', [
            'key_exists' => !empty($key),
            'length' => strlen($key ?? '')
        ]);

        if (strlen($key) !== 32) {
            Log::error('Invalid encryption key length', [
                'expected' => 32,
                'actual' => strlen($key)
            ]);
            throw new \Exception('Kunci enkripsi tidak valid');
        }

        $method = 'AES-256-CBC';
        Log::debug('Decryption attempt:', ['method' => $method]);

        $decrypted = openssl_decrypt($encryptedData, $method, $key, 0, $iv);
        Log::debug('Decryption result:', ['decrypted' => $decrypted]);

        if ($decrypted === false) {
            $error = openssl_error_string();
            Log::error('Decryption failed', ['error' => $error]);
            throw new \Exception('Gagal mendekripsi kode tiket. ' . $error);
        }

        $jsonDecoded = json_decode($decrypted, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            Log::debug('Decrypted JSON content:', $jsonDecoded);
        }

        Log::info('Decryption successful');
        return $decrypted;
    }
}
