<?php

namespace App\Repositories\Eloquent;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function getAllNested(): Collection
    {
        return Cache::remember('categories.all', now()->addMinutes(30), function () {
            return $this->model->withCount('products')
                ->with('children:id,parent_id,name,slug')
                ->whereNull('parent_id') // top-level only; children nested
                ->orderBy('name')
                ->get();
        });
    }

    public function findByIdWithProducts(int $categoryId): Category
    {
        $category = $this->model->findOrFail($categoryId);

        return $category->load([
            'products' => fn($q) => $q->where('status', 'active')->with(['images', 'variants']),
        ])->loadCount('products');
    }
}
