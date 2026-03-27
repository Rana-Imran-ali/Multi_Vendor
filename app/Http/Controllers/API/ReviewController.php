<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index($productId)
    {
        $reviews = Review::where('product_id', $productId)->with('user:id,name')->latest()->get();
        return response()->json(['status' => 'success', 'data' => $reviews]);
    }

    public function store(Request $request, $productId)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        $product = Product::findOrFail($productId);
        $user = $request->user();

        // Check if user has already reviewed
        $existingReview = Review::where('user_id', $user->id)
                                ->where('product_id', $product->id)
                                ->first();

        if ($existingReview) {
            return response()->json(['status' => 'error', 'message' => 'You have already reviewed this product.'], 400);
        }

        $review = Review::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null
        ]);

        return response()->json(['status' => 'success', 'message' => 'Review added successfully', 'data' => $review], 201);
    }
}
