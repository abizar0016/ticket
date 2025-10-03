<?php

namespace App\Services\Events;

use App\Actions\Events\StoreEvent;
use App\Actions\Events\TogglePublishEvent;
use App\Actions\Events\UpdateEvent;
use App\Actions\Events\DeleteEvent;
use Illuminate\Http\Request;

class EventService
{
    public function store(Request $request)
    {
        return (new StoreEvent())->handle($request);
    }

    public function togglePublish(Request $request, $id)
    {
        return (new TogglePublishEvent())->handle($request, $id);
    }

    public function update(Request $request, $id)
    {
        return (new UpdateEvent())->handle($request, $id);
    }

    public function destroy($id)
    {
        return (new DeleteEvent())->handle($id);
    }
}
