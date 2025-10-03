<?php

namespace App\Http\Controllers\SuperAdmin\Users;

use App\Http\Controllers\SuperAdmin\SuperAdminBaseController;
use App\Models\Organization;

class SuperAdminOrganizationsController extends SuperAdminBaseController
{
    public function index()
    {
        $viewData = $this->getViewData('organizations');

        $organizations = Organization::with('user')
            ->latest()
            ->paginate(10);

        return view('layouts.superAdmin.index', array_merge($viewData, [
            'organizations' => $organizations,
        ]));
    }
}
