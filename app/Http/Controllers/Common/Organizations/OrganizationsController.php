<?php

namespace App\Http\Controllers\Common\Organizations;

use App\Http\Controllers\Controller;
use App\Services\Organizations\OrganizationService;
use Illuminate\Http\Request;

class OrganizationsController extends Controller
{
    protected OrganizationService $service;

    public function __construct(OrganizationService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        return $this->service->store($request);
    }

    public function update(Request $request, $id)
    {
        return $this->service->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}
