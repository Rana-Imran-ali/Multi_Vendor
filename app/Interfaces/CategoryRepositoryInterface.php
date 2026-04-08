<?php

namespace App\Interfaces;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    /**
     * Get all top-level categories with their nested children.
     */
    public function getAllNested(): Collection;

    /**
     * Get a specific category alongside its active products.
     */
    public function findByIdWithProducts(int $categoryId): Category;
}
