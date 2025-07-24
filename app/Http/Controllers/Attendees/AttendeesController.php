<?php

namespace App\Http\Controllers\Attendees;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttendeesController extends Controller
{
    public function update(Request $request, $id)
    {
        $attendee = Attendee::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'ticket_code' => 'required|string|max:255',
            'status' => 'required|in:active,pending',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $attendee->update([
            'name' => $request->name,
            'email' => $request->email,
            'ticket_code' => $request->ticket_code,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Attendee updated successfully.',
        ]);
    }

    public function destroy($id)
    {
        $attendee = Attendee::findOrFail($id);
        $attendee->delete();
        return response()->json([
            'success' => true,
            'message' => 'Attendee deleted successfully.',
        ]);
    }
}
