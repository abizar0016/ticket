<?php

namespace App\Actions\Categories;

use App\Models\Category;

class DeleteCategory
{
    public function handle($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully!',
        ]);
    }
}