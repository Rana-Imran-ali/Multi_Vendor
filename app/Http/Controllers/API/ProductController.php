<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use App\Services\ProductService;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    use ApiResponse;
    
    public function __construct(
        protected ProductService $productService,
        protected ProductRepositoryInterface $productRepository,
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

        $cacheKey = $this->buildCacheKey($request);
        $perPage  = (int) $request->input('per_page', 15);

        $result = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($request, $perPage) {
            return $this->productRepository->getApprovedCatalog($request->all(), $perPage);
        });

        $data = [
            'products' => ProductResource::collection($result),
            'meta' => [
                'per_page'    => $perPage,
                'next_cursor' => $result->nextCursor()?->encode(),
                'prev_cursor' => $result->previousCursor()?->encode(),
                'has_more'    => $result->hasMorePages(),
            ],
        ];

        return $this->successResponse($data, 'Products retrieved successfully.');
    }

    /**
     * Show a single active product with full details.
     * Cached individually by product ID.
     */
    public function show(Product $product)
    {
        if ($product->status !== 'active') {
            return $this->errorResponse('Product not found.', 404);
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

        return $this->successResponse(new ProductResource($product), 'Product retrieved successfully.');
    }

    /**
     * Store a new product. Vendor must be approved.
     * Clears catalog cache on success.
     */
    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->createProduct($request->validated(), $request->user());

        Cache::flush();

        return $this->successResponse(new ProductResource($product), 'Product created. Pending admin approval.', 201);
    }

    /**
     * Update a product. Clears that product's and catalog cache.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product = $this->productService->updateProduct($product, $request->validated());

        Cache::forget("product:{$product->id}");
        Cache::flush();

        return $this->successResponse(new ProductResource($product), 'Product updated successfully.');
    }

    /**
     * Delete a product owned by the authenticated vendor.
     */
    public function destroy(Request $request, Product $product)
    {
        $user = $request->user();

        if (! $user->vendor || $user->vendor->id !== $product->vendor_id) {
            return $this->errorResponse('Unauthorized. You do not own this product.', 403);
        }

        $product->delete();

        Cache::forget("product:{$product->id}");
        Cache::flush();

        return $this->successResponse(null, 'Product deleted successfully.');
    }

    /**
     * Vendor's own product list — all statuses, no caching needed.
     */
    public function vendorProducts(Request $request)
    {
        $user = $request->user();

        if (! $user->vendor) {
            return $this->errorResponse('Not a vendor.', 403);
        }

        $products = $this->productRepository->getByVendor($user->vendor->id);

        return $this->successResponse(ProductResource::collection($products), 'Vendor products retrieved.');
    }

    /**
     * Helper to build a unique cache key based on query parameters.
     */
    private function buildCacheKey(Request $request): string
    {
        $params = $request->only([
            'search', 'category_id', 'min_price', 'max_price',
            'min_rating', 'vendor_id', 'sort', 'cursor', 'per_page',
        ]);
        ksort($params);
        return 'products:' . md5(serialize($params));
    }
}
