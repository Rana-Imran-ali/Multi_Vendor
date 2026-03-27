<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Public listing, optionally filter by category or vendor
        $query = Product::with(['vendor', 'category']);

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('vendor_id')) {
            $query->where('vendor_id', $request->vendor_id);
        }

        $products = $query->latest()->paginate(15);
        return response()->json(['status' => 'success', 'data' => $products]);
    }

    public function store(Request $request)
    {
        // Only vendors can create products
        $user = $request->user();
        if (!$user->vendor || $user->vendor->status !== 'approved') {
            return response()->json(['status' => 'error', 'message' => 'Only approved vendors can create products'], 403);
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|string'
        ]);

        $product = Product::create([
            ...$validated,
            'vendor_id' => $user->vendor->id,
            'slug' => Str::slug($validated['name']) . '-' . uniqid()
        ]);

        return response()->json(['status' => 'success', 'message' => 'Product created successfully', 'data' => $product], 201);
    }

    public function show(Product $product)
    {
        return response()->json(['status' => 'success', 'data' => $product->load(['vendor', 'category', 'reviews.user'])]);
    }

    public function update(Request $request, Product $product)
    {
        $user = $request->user();
        if (!$user->vendor || $user->vendor->id !== $product->vendor_id) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized. You do not own this product.'], 403);
        }

        $validated = $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'stock' => 'sometimes|integer|min:0',
            'image' => 'nullable|string'
        ]);

        if (isset($validated['name']) && $validated['name'] !== $product->name) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . uniqid();
        }

        $product->update($validated);

        return response()->json(['status' => 'success', 'message' => 'Product updated successfully', 'data' => $product]);
    }

    public function destroy(Request $request, Product $product)
    {
        $user = $request->user();
        if (!$user->vendor || $user->vendor->id !== $product->vendor_id) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized. You do not own this product.'], 403);
        }

        $product->delete();

        return response()->json(['status' => 'success', 'message' => 'Product deleted successfully']);
    }

    public function vendorProducts(Request $request)
    {
        $user = $request->user();
        if (!$user->vendor) {
            return response()->json(['status' => 'error', 'message' => 'Not a vendor'], 403);
        }

        $products = Product::where('vendor_id', $user->vendor->id)->with('category')->get();
        return response()->json(['status' => 'success', 'data' => $products]);
    }
}
