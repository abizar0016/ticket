<?php

namespace App\Actions\Events;

use App\Models\{Event, Activity};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StoreEvent
{
    public function handle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'categories_id' => 'required|exists:categories,id',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after:start_date',
            'event_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'status'      => 'nullable|in:draft,published',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()->all(),
            ], 422);
        }

        $data = $validator->validated();

        // Upload image
        if ($request->hasFile('event_image')) {
            $image = $request->file('event_image');
            $imageName = time().'_'.Str::random(10).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('event_images'), $imageName);
            $data['event_image'] = 'event_images/'.$imageName;
        }

        // Unique code
        do {
            $eventCode = strtoupper(Str::random(4));
        } while (Event::where('event_code', $eventCode)->exists());

        $data['event_code'] = $eventCode;
        $data['user_id']    = Auth::id();
        $data['status']     = $data['status'] ?? 'draft';

        if ($org = Auth::user()->organization) {
            $data['organization_id'] = $org->id;
        }

        $event = Event::create($data);

        Activity::create([
            'user_id'    => Auth::id(),
            'action'     => 'Create',
            'model_type' => 'Event',
            'model_id'   => $event->id,
        ]);

        return response()->json([
            'success'  => true,
            'message'  => 'Event created successfully!',
            'redirect' => route(Auth::user()->role === 'superadmin' ? 'superAdmin.events.dashboard' : 'admin.events.dashboard', $event->id),
        ]);
    }
}
