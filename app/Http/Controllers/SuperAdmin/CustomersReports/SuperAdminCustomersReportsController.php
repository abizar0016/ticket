<?php

namespace App\Http\Controllers\SuperAdmin\CustomersReports;

use App\Http\Controllers\SuperAdmin\SuperAdminBaseController;
use App\Models\Report;

class SuperAdminCustomersReportsController extends SuperAdminBaseController
{
    public function index()
    {
        $viewData = $this->getViewData('customers-reports');

        $customersReports = Report::with(['user', 'event'])
            ->latest()
            ->paginate(10);

        return view('layouts.superAdmin.index', array_merge($viewData, [
            'customersReports' => $customersReports,
        ]));
    }
}
