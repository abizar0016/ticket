<?php

namespace App\Http\Controllers\Action;

use App\Models\Event;
use App\Models\EventLocation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    use AuthorizesRequests;
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'event_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'status' => 'nullable|in:draft,published',
                'timezone' => 'nullable|string|max:255',
                'organizer_id' => 'nullable|exists:organizers,id'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()->all(),
                ], 422);
            }

            $data = $validator->validated();

            if ($request->hasFile('event_image')) {

                $publicPath = public_path('event_images');
                if (!file_exists($publicPath)) {
                    mkdir($publicPath, 0777, true);
                }

                $image = $request->file('event_image');
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('event_images'), $imageName);
                $data['event_image'] = 'event_images/' . $imageName;
            }

            // Generate unique event_id
            do {
                $eventCode = strtoupper(Str::random(4));
            } while (Event::where('event_code', $eventCode)->exists());

            $data['event_code'] = $eventCode;
            $data['user_id'] = Auth::id();
            $data['status'] = $data['status'] ?? 'draft';
            $data['timezone'] = $data['timezone'] ?? 'Asia/Jakarta';

            $event = Event::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Event created successfully!',
                'redirect' => route('event.dashboard', $event->id)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $event = Event::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'organizer_id' => 'nullable|exists:organizers,id',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
                'timezone' => 'required|timezone',
                'event_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'venue_name' => 'nullable|string|max:255',
                'address_line' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:255',
                'state' => 'nullable|string|max:255',
                'custom_maps_url' => 'nullable|string',
                'bank_name' => 'nullable|string|max:255',
                'bank_account_number' => 'nullable|string|max:255',
                'bank_account_name' => 'nullable|string|max:255',
                'status' => 'required|in:draft,published'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()->all()
                ], 422);
            }

            $updateData = $validator->validated();

            // Handle image update
            if ($request->hasFile('event_image')) {
                $publicPath = public_path('event_images');

                // Buat folder jika belum ada
                if (!file_exists($publicPath)) {
                    mkdir($publicPath, 0755, true);
                }

                // Hapus gambar lama
                if ($event->event_image && file_exists(public_path($event->event_image))) {
                    unlink(public_path($event->event_image));
                }

                $imageName = time() . '_' . Str::random(10) . '.' . $request->file('event_image')->getClientOriginalExtension();
                $request->file('event_image')->move($publicPath, $imageName);
                $updateData['event_image'] = 'event_images/' . $imageName;
            }

            $event->update($updateData);

            $locationData = [
                'venue_name' => $request->venue_name,
                'address_line' => $request->address_line,
                'city' => $request->city,
                'state' => $request->state,
                'custom_maps_url' => $request->custom_maps_url
            ];

            if ($event->location) {
                $event->location()->update($locationData);
            } else {
                $event->location()->create($locationData);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Event updated successfully!',
                'data' => $event->load('location')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update event',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $event = Event::with('products')->findOrFail($id);

        if ($event->event_image && file_exists(public_path($event->event_image))) {
            unlink(public_path($event->event_image));
        }

        foreach ($event->products as $product) {
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            $product->delete();
        }

        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event deleted successfully!'
        ]);
    }
}
