<?php

namespace App\Actions\Organizations;

use App\Models\Organization;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteOrganization
{
    public function handle($id)
    {
        return DB::transaction(function () use ($id) {
            $organization = Organization::with([
                'events.orders.items',
                'events.attendees',
                'events.promos', // tambahkan relasi promo juga
            ])->findOrFail($id);

            // Hapus semua event dan data terkait
            foreach ($organization->events as $event) {
                // Hapus promos terkait
                foreach ($event->promos as $promo) {
                    $promo->delete();
                }

                // Hapus orders dan order items terkait event
                foreach ($event->orders as $order) {
                    foreach ($order->items as $item) {
                        $item->delete();
                    }
                    $order->delete();
                }

                // Hapus attendees terkait event
                foreach ($event->attendees as $attendee) {
                    $attendee->delete();
                }

                // Hapus gambar event kalau ada
                if ($event->image && file_exists(public_path('event_image/' . $event->image))) {
                    @unlink(public_path('event_image/' . $event->image));
                }

                $event->delete();
            }

            // Setelah semua event dan relasinya aman dihapus → hapus organisasi
            $organization->delete();

            // Simpan aktivitas
            Activity::create([
                'user_id' => Auth::id(),
                'action' => 'Delete',
                'model_type' => 'Organization',
                'model_id' => $organization->id,
            ]);

            return response()->json([
                'success' => true
            ]);
        });
    }
}
