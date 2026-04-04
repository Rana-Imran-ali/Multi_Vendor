<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductService;
use App\Services\ProductQueryService;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected ProductQueryService $productQueryService,
    ) {}

    /**
     * Public catalog endpoint with search, filters, sorting, and cursor pagination.
     * Results are cached per unique request signature.
     */
    public function index(Request $request)
    {
        $request->validate([
            'search'      => 'nullable|string|max:100',
            'category_id' => 'nullable|integer|exists:categories,id',
            'vendor_id'   => 'nullable|integer|exists:vendors,id',
            'min_price'   => 'nullable|numeric|min:0',
            'max_price'   => 'nullable|numeric|min:0|gte:min_price',
            'min_rating'  => 'nullable|numeric|min:1|max:5',
            'sort'        => 'nullable|in:latest,price_asc,price_desc,rating',
            'per_page'    => 'nullable|integer|min:5|max:50',
            'cursor'      => 'nullable|string',
        ]);

        $cacheKey = $this->productQueryService->buildCacheKey($request);
        $perPage  = (int) $request->input('per_page', 15);

        $result = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($request, $perPage) {
            $query = $this->productQueryService->buildCatalogQuery($request);
            return $query->cursorPaginate($perPage);
        });

        return ProductResource::collection($result)->additional([
            'meta' => [
                'per_page'    => $perPage,
                'next_cursor' => $result->nextCursor()?->encode(),
                'prev_cursor' => $result->previousCursor()?->encode(),
                'has_more'    => $result->hasMorePages(),
            ],
        ]);
    }

    /**
     * Show a single active product with full details.
     * Cached individually by product ID.
     */
    public function show(Product $product)
    {
        if ($product->status !== 'active') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Product not found.',
            ], 404);
        }

        $cacheKey = "product:{$product->id}";

        $product = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($product) {
            return $product->load([
                'vendor:id,store_name,description,created_at',
                'category:id,name,slug',
                'variants',
                'images',
                'reviews.user:id,name',
            ])->loadAvg('reviews', 'rating')->loadCount('reviews');
        });

        return new ProductResource($product);
    }

    /**
     * Store a new product. Vendor must be approved.
     * Clears catalog cache on success.
     */
    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->createProduct($request->validated(), $request->user());

        // Bust catalog cache so new product appears immediately
        Cache::flush(); // Simple strategy; use Tags if Redis is available

        return response()->json([
            'status'  => 'success',
            'message' => 'Product created. Pending admin approval.',
            'data'    => new ProductResource($product),
        ], 201);
    }

    /**
     * Update a product. Clears that product's and catalog cache.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product = $this->productService->updateProduct($product, $request->validated());

        Cache::forget("product:{$product->id}");
        Cache::flush(); // Bust catalog

        return response()->json([
            'status'  => 'success',
            'message' => 'Product updated successfully.',
            'data'    => new ProductResource($product),
        ]);
    }

    /**
     * Delete a product owned by the authenticated vendor.
     */
    public function destroy(Request $request, Product $product)
    {
        $user = $request->user();

        if (! $user->vendor || $user->vendor->id !== $product->vendor_id) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized. You do not own this product.',
            ], 403);
        }

        $product->delete();

        Cache::forget("product:{$product->id}");
        Cache::flush();

        return response()->json([
            'status'  => 'success',
            'message' => 'Product deleted successfully.',
        ]);
    }

    /**
     * Vendor's own product list — all statuses, no caching needed.
     */
    public function vendorProducts(Request $request)
    {
        $user = $request->user();

        if (! $user->vendor) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Not a vendor.',
            ], 403);
        }

        $products = Product::where('vendor_id', $user->vendor->id)
            ->with(['category:id,name', 'variants', 'images'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->latest()
            ->get();

        return ProductResource::collection($products);
    }
}
