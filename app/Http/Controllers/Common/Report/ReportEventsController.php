<?php

namespace App\Http\Controllers\Common\Report;

use App\Http\Controllers\Controller;
use App\Services\Reports\ReportEventsService;
use Illuminate\Http\Request;

class ReportEventsController extends Controller
{
    protected ReportEventsService $reportEventsService;

    public function __construct(ReportEventsService $reportEventsService)
    {
        $this->reportEventsService = $reportEventsService;
    }

    public function store(Request $request, $id)
    {
        return $this->reportEventsService->store($request, $id);
    }


    public function adminUpdate(Request $request, $id)
    {
        return $this->reportEventsService->adminUpdate($request, $id);
    }

    public function superAdminUpdate(Request $request, $id)
    {
        return $this->reportEventsService->superAdminUpdate($request, $id);
    }

    public function superAdminDestroy($id)
    {
        return $this->reportEventsService->superAdminDestroy($id);
    }
}
