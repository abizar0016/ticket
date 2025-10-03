<?php

namespace App\Services\Checkins;

use App\Actions\Checkins\ProcessCheckin;
use App\Actions\Checkins\ProcessManualCheckin;
use Illuminate\Http\Request;

class CheckinService
{
    public function processCheckin(Request $request)
    {
        return (new ProcessCheckin())->handle($request);
    }

    public function processManualCheckin(Request $request)
    {
        return (new ProcessManualCheckin())->handle($request);
    }
}
