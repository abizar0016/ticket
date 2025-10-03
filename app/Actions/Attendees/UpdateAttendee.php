<?php

namespace App\Actions\Attendees;

use App\Models\{Attendee, Activity};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UpdateAttendee
{
    public function handle(Request $request, $id)
    {
        $attendee = Attendee::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'ticket_code' => 'required|string|max:255',
            'status' => 'required|in:active,pending,used',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $attendee->update([
            'name'        => $request->name,
            'email'       => $request->email,
            'ticket_code' => $request->ticket_code,
            'status'      => $request->status,
        ]);

        Activity::create([
            'user_id'    => Auth::id(),
            'action'     => 'update attendee',
            'model_type' => 'Attendee',
            'model_id'   => $attendee->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Attendee updated successfully.',
        ]);
    }
}
