<?php

namespace App\Actions\Categories;

use App\Models\Activity;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class DeleteCategory
{
    public function handle($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'Delete',
            'model_type' => 'Category',
            'model_id' => $category->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully!',
        ]);
    }
}