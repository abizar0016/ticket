<?php

namespace App\Http\Controllers\Admin\Actions;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Organization;

class AdminManageOrganizationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            // Buat organization baru
            $organization = Organization::create([
                'name' => $request->name,
            ]);

            // Update user yang sedang login → assign organization_id
            $user = Auth::user();
            $user->organization_id = $organization->id;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Organization created successfully!',
                'organization_id' => $organization->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat organisasi: ' . $e->getMessage()
            ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $organization = Organization::findOrFail($id);
            $organization->name = $request->name;
            $organization->save();

            return back()->with('success', 'Organization updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal update organisasi: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->delete();
        return redirect()->back()->with('success', 'Organization deleted successfully!');
    }
}
