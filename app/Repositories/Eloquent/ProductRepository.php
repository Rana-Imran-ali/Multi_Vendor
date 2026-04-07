<?php

namespace App\Repositories\Eloquent;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\CursorPaginator;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function getApprovedCatalog(array $filters, int $perPage): CursorPaginator
    {
        $query = $this->model
            ->where('status', 'active')
            ->with(['vendor:id,store_name,slug', 'category:id,name,slug', 'images', 'variants'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews');

        if (! empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        if (! empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (! empty($filters['vendor_id'])) {
            $query->where('vendor_id', $filters['vendor_id']);
        }

        if (! empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (! empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        if (! empty($filters['min_rating'])) {
            $query->having('reviews_avg_rating', '>=', $filters['min_rating']);
        }

        $sort = $filters['sort'] ?? 'latest';
        match ($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'rating'     => $query->orderByDesc('reviews_avg_rating'),
            default      => $query->latest(),
        };

        return $query->cursorPaginate($perPage);
    }

    public function getByVendor(int $vendorId): Collection
    {
        return $this->model
            ->where('vendor_id', $vendorId)
            ->with(['category:id,name', 'variants', 'images'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->latest()
            ->get();
    }

    public function getPending(): Collection
    {
        return $this->model
            ->where('status', 'pending')
            ->with(['vendor:id,store_name', 'category:id,name'])
            ->latest()
            ->get();
    }
}
