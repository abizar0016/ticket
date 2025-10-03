<?php

namespace App\Http\Controllers\Common\Attendees;

use App\Http\Controllers\Controller;
use App\Services\Attendees\AttendeeService;
use Illuminate\Http\Request;

class AttendeesController extends Controller
{
    protected AttendeeService $service;

    public function __construct(AttendeeService $service)
    {
        $this->service = $service;
    }

    public function update(Request $request, $id)
    {
        return $this->service->update($request, $id);
    }

    public function delete($id)
    {
        return $this->service->delete($id);
    }
}
