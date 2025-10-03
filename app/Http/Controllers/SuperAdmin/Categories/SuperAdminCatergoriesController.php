<?php

namespace App\Http\Controllers\SuperAdmin\Categories;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SuperAdmin\SuperAdminBaseController;
use App\Models\Category;
use Illuminate\Http\Request;

class SuperAdminCatergoriesController extends SuperAdminBaseController
{
    public function index()
    {
        $viewData = $this->getViewData('categories');

        $categories = Category::all();

        return view('layouts.superAdmin.index', array_merge($viewData, [
            'categories' => $categories,
        ]));
    }
}
