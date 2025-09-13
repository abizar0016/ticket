<?php

namespace App\Http\Controllers\SuperAdmin\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuperAdminDashboardController extends SuperAdminBaseController
{
    public function index() {
        $viewData = $this->getViewData('dashboard');
        return view('superAdmin.index', array_merge($viewData,[
            
        ]));
    }
}
