<?php

namespace App\Http\Controllers\Common\Categories;

use App\Http\Controllers\Controller;
use App\Services\Categories\CategoryService;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    protected CategoryService $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function create(Request $request)
    {
        return $this->service->create($request);
    }

    public function delete($id)
    {
        return $this->service->delete($id);
    }
}