<?php

namespace App\Services\Attendees;

use App\Actions\Attendees\UpdateAttendee;
use App\Actions\Attendees\DeleteAttendee;
use Illuminate\Http\Request;

class AttendeeService
{
    public function update(Request $request, $id)
    {
        return (new UpdateAttendee())->handle($request, $id);
    }

    public function delete($id)
    {
        return (new DeleteAttendee())->handle($id);
    }
}
