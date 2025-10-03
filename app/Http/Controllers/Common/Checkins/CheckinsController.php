<?php

namespace App\Http\Controllers\Common\Checkins;

use App\Http\Controllers\Controller;
use App\Services\Checkins\CheckinService;
use Illuminate\Http\Request;

class CheckinsController extends Controller
{
    protected CheckinService $service;

    public function __construct(CheckinService $service)
    {
        $this->service = $service;
    }

    public function processCheckin(Request $request)
    {
        $request->validate(['ticket_code' => 'required|string']);
        return $this->service->processCheckin($request);
    }

    public function processManualCheckin(Request $request)
    {
        $request->validate(['ticket_code' => 'required|string']);
        return $this->service->processManualCheckin($request);
    }
}
