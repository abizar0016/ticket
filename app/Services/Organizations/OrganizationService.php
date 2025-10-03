<?php

namespace App\Services\Organizations;

use App\Actions\Organizations\StoreOrganization;
use App\Actions\Organizations\UpdateOrganization;
use App\Actions\Organizations\DeleteOrganization;
use Illuminate\Http\Request;

class OrganizationService
{
    public function store(Request $request)
    {
        return (new StoreOrganization())->handle($request);
    }

    public function update(Request $request, $id)
    {
        return (new UpdateOrganization())->handle($request, $id);
    }

    public function delete($id)
    {
        return (new DeleteOrganization())->handle($id);
    }
}