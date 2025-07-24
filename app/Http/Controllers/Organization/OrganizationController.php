<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Organizer;

class OrganizationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $organization = new Organizer;
            $organization->user_id = Auth::id(); // atau $request->user_id jika dari input
            $organization->name = $request->name;

            $organization->save();

            return response()->json([
                'success' => true,
                'message' => 'Organization created successfully!'
            ]);
        } catch (Exception $e) {
            return back()->with('error', 'Gagal membuat organisasi: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $organization = Organizer::findOrFail($id);
        $organization->name = $request->name;
        $organization->save();
        return back()->with('success', 'Organization updated successfully!');
    }

    public function destroy($id)
    {
        $organization = Organizer::findOrFail($id);
        $organization->delete();
        return redirect()->back()->with('success', 'Organization deleted successfully!');
    }
}
