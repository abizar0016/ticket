<?php

namespace App\Actions\Organizations;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UpdateOrganization
{
    public function handle(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $organization = Organization::findOrFail($id);
            $organization->update([
                'name' => $request->name,
            ]);

            return back()->with('success', 'Organization updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal update organisasi: ' . $e->getMessage());
        }
    }
}
