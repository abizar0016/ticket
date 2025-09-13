<?php

namespace App\Http\Controllers\SuperAdmin\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminBaseController extends Controller
{
    protected function getViewData($activeContent){
        return [
            'activeContent' => $activeContent,
            'user' =>Auth::user(),
        ];
    }
}
