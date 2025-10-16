<?php

namespace App\Services\Reports;

use App\Actions\Reports\StoreReport;
use App\Actions\Reports\adminUpdate;
use App\Actions\Reports\superAdminUpdate;
use App\Actions\Reports\superAdminDestroy;
use Illuminate\Http\Request;

class ReportEventsService
{
    public function store(Request $request, $id)
    {
        return (new StoreReport)->handle($request, $id);
    }

    public function adminUpdate(Request $request, $id)
    {
        return (new adminUpdate)->handle($request, $id);
    }

    public function superAdminUpdate(Request $request, $id)
    {
        return (new superAdminUpdate)->handle($request, $id);
    }

    public function superAdminDestroy($id)
    {
        return (new superAdminDestroy)->handle($id);
    }
}