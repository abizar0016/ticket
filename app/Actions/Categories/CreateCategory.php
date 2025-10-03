<?php

namespace App\Actions\Categories;

use App\Models\Category;
use Illuminate\Http\Request;

class CreateCategory
{
    public function handle(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully.',
        ]);
    }
}
