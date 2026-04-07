<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use ApiResponse;

    /**
     * Public: list all categories (with child count), cached for 30 min.
     */
    public function index()
    {
        $categories = Cache::remember('categories.all', now()->addMinutes(30), function () {
            return Category::withCount('products')
                ->with('children:id,parent_id,name,slug')
                ->whereNull('parent_id')   // top-level only; children nested
                ->orderBy('name')
                ->get();
        });

        return $this->successResponse($categories, 'Categories retrieved successfully.');
    }

    /**
     * Public: show a single category with its products.
     */
    public function show(Category $category)
    {
        $category->load([
            'products' => fn($q) => $q->where('status', 'active')->with(['images', 'variants']),
        ])->loadCount('products');

        return $this->successResponse($category, 'Category retrieved successfully.');
    }

    /**
     * Admin: create a category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:categories',
            'parent_id'   => 'nullable|integer|exists:categories,id',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:100',
        ]);

        $category = Category::create([
            'name'        => $validated['name'],
            'slug'        => Str::slug($validated['name']),
            'parent_id'   => $validated['parent_id'] ?? null,
            'description' => $validated['description'] ?? null,
            'icon'        => $validated['icon'] ?? null,
        ]);

        Cache::forget('categories.all');

        return $this->successResponse($category, 'Category created successfully.', 201);
    }

    /**
     * Admin: update a category.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name,' . $category->id,
            'parent_id'   => 'nullable|integer|exists:categories,id',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:100',
        ]);

        $category->update([
            'name'        => $validated['name'],
            'slug'        => Str::slug($validated['name']),
            'parent_id'   => $validated['parent_id'] ?? $category->parent_id,
            'description' => $validated['description'] ?? $category->description,
            'icon'        => $validated['icon'] ?? $category->icon,
        ]);

        Cache::forget('categories.all');

        return $this->successResponse($category->fresh(), 'Category updated successfully.');
    }

    /**
     * Admin: delete a category.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        Cache::forget('categories.all');

        return $this->successResponse(null, 'Category deleted successfully.');
    }
}
