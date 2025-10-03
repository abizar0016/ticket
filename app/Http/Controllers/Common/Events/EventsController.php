<?php

namespace App\Http\Controllers\Common\Events;

use App\Http\Controllers\Controller;
use App\Services\Events\EventService;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    protected EventService $service;

    public function __construct(EventService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        return $this->service->store($request);
    }

    public function togglePublish(Request $request, $id)
    {
        return $this->service->togglePublish($request, $id);
    }

    public function update(Request $request, $id)
    {
        return $this->service->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->service->destroy($id);
    }
}
