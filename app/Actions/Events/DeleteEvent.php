<?php

namespace App\Actions\Events;

use App\Models\{Event, Activity};
use Illuminate\Support\Facades\Auth;

class DeleteEvent
{
    public function handle($id)
    {
        $event = Event::with('products')->findOrFail($id);

        // Delete event image
        if ($event->event_image && file_exists(public_path($event->event_image))) {
            unlink(public_path($event->event_image));
        }

        // Delete product images
        foreach ($event->products as $product) {
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $product->delete();
        }

        $event->delete();

        Activity::create([
            'user_id'    => Auth::id(),
            'action'     => 'Delete',
            'model_type' => 'Event',
            'model_id'   => $id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Event deleted successfully!',
        ]);
    }
}
