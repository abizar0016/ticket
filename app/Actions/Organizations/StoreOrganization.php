<?php

namespace App\Actions\Organizations;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StoreOrganization
{
    public function handle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = Auth::user();

        // 🔒 Cek dulu apakah user sudah punya organisasi
        if ($user->organization_id) {
            return response()->json([
                'success' => false,
                'message' => 'User already has an organization.',
            ], 400);
        }

        try {
            $organization = Organization::create([
                'name' => $request->name,
            ]);

            $user->organization_id = $organization->id;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Organization created successfully!',
                'organization_id' => $organization->id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat organisasi: ' . $e->getMessage(),
            ], 500);
        }
    }
}
