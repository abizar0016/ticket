<?php

namespace App\Actions\Attendees;

use App\Models\{Attendee, Activity};
use Illuminate\Support\Facades\Auth;

class DeleteAttendee
{
    public function handle($id)
    {
        $attendee = Attendee::findOrFail($id);
        $attendee->delete();

        Activity::create([
            'user_id'    => Auth::id(),
            'action'     => 'Delete',
            'model_type' => 'Attendee',
            'model_id'   => $attendee->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Attendee deleted successfully.',
        ]);
    }
}
