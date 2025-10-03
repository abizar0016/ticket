<?php

namespace App\Services\Categories;

use App\Actions\Categories\CreateCategory;
use App\Actions\Categories\DeleteCategory;
use Illuminate\Http\Request;

class CategoryService
{
    public function create(Request $request)
    {
        return (new CreateCategory())->handle($request);
    }

    public function delete($id)
    {
        return (new DeleteCategory())->handle($id);
    }
}