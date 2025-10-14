<?php

namespace App\Actions\Organizations;

use App\Models\Activity;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;

class DeleteOrganization
{
    public function handle($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->delete();

        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'Delete',
            'model_type' => 'Organization',
            'model_id' => $organization->id,
        ]);

        return redirect()->back()->with('success', 'Organization deleted successfully!');
    }
}
