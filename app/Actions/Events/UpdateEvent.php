<?php

namespace App\Actions\Events;

use App\Models\{Event, Activity};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UpdateEvent
{
    public function handle(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $events = Event::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'title'       => 'required|string|max:255',
                'description' => 'required|string',
                'start_date'  => 'required|date',
                'end_date'    => 'required|date|after:start_date',
                'event_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'venue_name'  => 'nullable|string|max:255',
                'address_line'=> 'nullable|string|max:255',
                'city'        => 'nullable|string|max:255',
                'state'       => 'nullable|string|max:255',
                'custom_maps_url' => 'nullable|string',
                'bank_name'   => 'nullable|string|max:255',
                'bank_account_number' => 'nullable|string|max:255',
                'bank_account_name'   => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $validator->errors()->all(),
                ], 422);
            }

            $updateData = $validator->validated();

            if ($org = Auth::user()->organization) {
                $updateData['organization_id'] = $org->id;
            }

            // Replace image if new uploaded
            if ($request->hasFile('event_image')) {
                $publicPath = public_path('event_images');

                if (! file_exists($publicPath)) {
                    mkdir($publicPath, 0755, true);
                }

                if ($events->event_image && file_exists(public_path($events->event_image))) {
                    unlink(public_path($events->event_image));
                }

                $imageName = time().'_'.Str::random(10).'.'.$request->file('event_image')->getClientOriginalExtension();
                $request->file('event_image')->move($publicPath, $imageName);
                $updateData['event_image'] = 'event_images/'.$imageName;
            }

            // Handle publish toggle
            $isPublished = $updateData['is_published'] ?? $events->is_published;
            $updateData['is_published'] = $isPublished;

            if ($isPublished) {
                $now = Carbon::now();
                $start = Carbon::parse($updateData['start_date']);
                $end = Carbon::parse($updateData['end_date']);

                if ($now->lt($start)) {
                    $updateData['status'] = 'upcoming';
                } elseif ($now->between($start, $end)) {
                    $updateData['status'] = 'ongoing';
                } elseif ($now->gt($end)) {
                    $updateData['status'] = 'ended';
                }
            } else {
                $updateData['status'] = 'draft';
            }

            $events->update($updateData);

            Activity::create([
                'user_id'    => Auth::id(),
                'action'     => 'update event',
                'model_type' => 'Event',
                'model_id'   => $events->id,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Event updated successfully!',
                'data'    => $events,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update event',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
