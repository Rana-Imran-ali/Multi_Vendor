<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductService;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;

class ProductApprovalController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * List all pending products
     */
    public function index()
    {
        $products = Product::where('status', 'pending')
                    ->with(['vendor', 'category', 'variants', 'images'])
                    ->latest()
                    ->paginate(15);
                    
        return ProductResource::collection($products);
    }

    /**
     * Approve a product
     */
    public function approve(Product $product)
    {
        $this->productService->changeStatus($product, 'active');

        return response()->json([
            'status' => 'success',
            'message' => 'Product approved successfully.',
            'data' => new ProductResource($product)
        ]);
    }

    /**
     * Reject a product
     */
    public function reject(Product $product)
    {
        $this->productService->changeStatus($product, 'rejected');

        return response()->json([
            'status' => 'success',
            'message' => 'Product rejected.',
            'data' => new ProductResource($product)
        ]);
    }
}
