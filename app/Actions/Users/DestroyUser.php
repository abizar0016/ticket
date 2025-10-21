<?php

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DestroyUser
{
    /**
     * Hapus user dan semua data yang terkait dengannya
     */
    public function handle(int $id)
    {
        return DB::transaction(function () use ($id) {
            $user = User::with([
                'organization',
                'events.products',
                'events.promos', // pastikan relasi promos sudah ada di model Event
                'events.attendees',
                'events.orders.items',
                'events.checkins',
                'events.reports',
                'orders.items',
                'orders.attendees',
                'reports',
            ])->find($id);

            if (! $user) {
                Log::warning("User dengan ID {$id} tidak ditemukan.");
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan.',
                ], 404);
            }

            Log::info("Mulai menghapus user ID {$user->id} - {$user->name}");

            /**
             * 1️⃣ Hapus foto profil
             */
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Log::info("Menghapus foto profil: {$user->profile_picture}");
                Storage::disk('public')->delete($user->profile_picture);
            }

            /**
             * 2️⃣ Hapus semua event milik user
             */
            foreach ($user->events as $event) {
                Log::info("Menghapus event ID {$event->id} ({$event->title}) milik user ID {$user->id}");

                // Hapus produk-produk event
                foreach ($event->products as $product) {
                    Log::info("→ Menghapus product ID {$product->id} milik event ID {$event->id}");
                    $product->delete();
                }

                // 🆕 Hapus promo event
                if (isset($event->promos)) {
                    foreach ($event->promos as $promo) {
                        Log::info("→ Menghapus promo ID {$promo->id} milik event ID {$event->id}");
                        $promo->delete();
                    }
                } elseif ($event->promo) {
                    Log::info("→ Menghapus promo ID {$event->promo->id} milik event ID {$event->id}");
                    $event->promo->delete();
                }

                // Hapus attendees
                foreach ($event->attendees as $attendee) {
                    Log::info("→ Menghapus attendee ID {$attendee->id} di event ID {$event->id}");
                    $attendee->delete();
                }

                // Hapus orders + order items
                foreach ($event->orders as $order) {
                    Log::info("→ Menghapus order ID {$order->id} di event ID {$event->id}");
                    foreach ($order->items as $item) {
                        Log::info("   → Menghapus order item ID {$item->id}");
                        $item->delete();
                    }

                    // Hapus attendees yang terkait dengan order ini
                    foreach ($order->attendees as $attendee) {
                        Log::info("   → Menghapus attendee ID {$attendee->id} dari order ID {$order->id}");
                        $attendee->delete();
                    }

                    $order->delete();
                }

                // Hapus checkins
                foreach ($event->checkins as $checkin) {
                    Log::info("→ Menghapus checkin ID {$checkin->id} di event ID {$event->id}");
                    $checkin->delete();
                }

                // Hapus reports
                foreach ($event->reports as $report) {
                    Log::info("→ Menghapus report ID {$report->id} di event ID {$event->id}");
                    $report->delete();
                }

                // Hapus gambar event di public/event_image/
                if ($event->image && file_exists(public_path('event_image/' . $event->image))) {
                    Log::info("→ Menghapus gambar event: {$event->image}");
                    @unlink(public_path('event_image/' . $event->image));
                }

                // Hapus event terakhir
                $event->delete();
            }

            /**
             * 3️⃣ Hapus semua order user (yang bukan dari event lain)
             */
            foreach ($user->orders as $order) {
                Log::info("Menghapus order ID {$order->id} milik user ID {$user->id}");

                // Hapus order items
                foreach ($order->items as $item) {
                    Log::info("→ Menghapus order item ID {$item->id}");
                    $item->delete();
                }

                // Hapus attendees
                foreach ($order->attendees as $attendee) {
                    Log::info("→ Menghapus attendee ID {$attendee->id} dari order ID {$order->id}");
                    $attendee->delete();
                }

                $order->delete();
            }

            /**
             * 4️⃣ Hapus report user (bukan report event)
             */
            foreach ($user->reports as $report) {
                Log::info("Menghapus report ID {$report->id} milik user ID {$user->id}");
                $report->delete();
            }

            /**
             * 5️⃣ Setelah semua event terhapus, baru hapus organization (biar gak kena FK constraint)
             */
            if ($user->organization) {
                Log::info("Menghapus organization ID {$user->organization->id} milik user ID {$user->id}");
                $user->organization->delete();
            }

            /**
             * 6️⃣ Terakhir, hapus user
             */
            $user->delete();
            Log::info("✅ User ID {$id} dan semua data terkait berhasil dihapus.");

            return response()->json([
                'success' => true,
                'message' => 'User dan semua data terkait berhasil dihapus.',
            ]);
        });
    }
}
