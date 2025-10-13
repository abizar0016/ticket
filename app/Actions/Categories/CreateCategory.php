<?php

namespace App\Actions\Categories;

use App\Models\Activity;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateCategory
{
    public function handle(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create($validated);

        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'created category',
            'model_type' => 'Category',
            'model_id' => $category->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully.',
        ]);
    }
}
