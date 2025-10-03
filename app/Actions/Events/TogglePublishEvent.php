<?php

namespace App\Actions\Events;

use App\Models\{Event, Activity};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TogglePublishEvent
{
    public function handle(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        try {
            $event->is_published = $request->input('is_published') == 1;

            $now = now();
            if ($event->is_published) {
                if ($now->lt($event->start_date)) {
                    $event->status = 'upcoming';
                } elseif ($now->between($event->start_date, $event->end_date)) {
                    $event->status = 'ongoing';
                } elseif ($now->gt($event->end_date)) {
                    $event->status = 'ended';
                }
            } else {
                $event->status = 'draft';
            }

            $event->save();

            Activity::create([
                'user_id'    => Auth::id(),
                'action'     => 'publish event',
                'model_type' => 'Event',
                'model_id'   => $event->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Event status updated!',
                'data'    => [
                    'is_published' => $event->is_published,
                    'status'       => $event->status,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update event status. Please try again.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
