<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ProductQueryService
{
    /**
     * Build a fully-optimized, filtered, and sorted query for the product catalog.
     * Separation of query-building concerns from the controller.
     */
    public function buildCatalogQuery(Request $request): Builder
    {
        $query = Product::query()
            ->where('status', 'active')
            // Aggregate avg_rating for filtering AND display — one DB round-trip
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            // Eager load all necessary relations — prevents N+1 completely
            ->with([
                'category:id,name,slug',
                'vendor:id,store_name,description',
                'images' => fn ($q) => $q->where('is_primary', true)->limit(1),
            ]);

        // --- Search ---
        if ($search = $request->input('search')) {
            $query->where(function (Builder $q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // --- Category Filter ---
        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        // --- Price Range Filter ---
        if ($minPrice = $request->input('min_price')) {
            $query->where('price', '>=', (float) $minPrice);
        }
        if ($maxPrice = $request->input('max_price')) {
            $query->where('price', '<=', (float) $maxPrice);
        }

        // --- Rating Filter ---
        // Uses HAVING clause on the aggregated avg from withAvg()
        if ($minRating = $request->input('min_rating')) {
            $query->having('reviews_avg_rating', '>=', (float) $minRating);
        }

        // --- Vendor Filter ---
        if ($vendorId = $request->input('vendor_id')) {
            $query->where('vendor_id', $vendorId);
        }

        // --- Sorting ---
        $sort = $request->input('sort', 'latest');
        match ($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'rating'     => $query->orderByDesc('reviews_avg_rating'),
            default      => $query->latest(), // 'latest'
        };

        return $query;
    }

    /**
     * Build a cache key unique to the exact request query string.
     * Sorted so key is stable regardless of parameter order.
     */
    public function buildCacheKey(Request $request, string $prefix = 'products'): string
    {
        $params = $request->only([
            'search', 'category_id', 'min_price', 'max_price',
            'min_rating', 'vendor_id', 'sort', 'cursor', 'per_page',
        ]);
        ksort($params);
        return $prefix . ':' . md5(serialize($params));
    }
}
