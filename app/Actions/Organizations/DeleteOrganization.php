<?php

namespace App\Actions\Organizations;

use App\Models\Organization;

class DeleteOrganization
{
    public function handle($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->delete();

        return redirect()->back()->with('success', 'Organization deleted successfully!');
    }
}
