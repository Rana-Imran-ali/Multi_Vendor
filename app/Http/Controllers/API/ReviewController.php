<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\Review;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use ApiResponse;

    /**
     * Resolve the model based on type and id.
     */
    protected function resolveModel(string $type, $id)
    {
        return match ($type) {
            'products' => Product::findOrFail($id),
            'vendors'  => Vendor::findOrFail($id),
            default    => abort(404, 'Invalid reviewable type.'),
        };
    }

    /**
     * Public: list all reviews for a product or vendor.
     */
    public function index($type, $id)
    {
        $model = $this->resolveModel($type, $id);

        $reviews = $model->reviews()
            ->with('user:id,name')
            ->latest()
            ->paginate(10);

        return $this->successResponse($reviews, 'Reviews retrieved successfully.');
    }

    /**
     * Customer: submit a review.
     */
    public function store(Request $request, $type, $id)
    {
        $validated = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $model = $this->resolveModel($type, $id);
        $user  = $request->user();

        // Prevent duplicate reviews
        $alreadyReviewed = $model->reviews()->where('user_id', $user->id)->exists();

        if ($alreadyReviewed) {
            return $this->errorResponse('You have already reviewed this item.', 409);
        }

        $review = $model->reviews()->create([
            'user_id' => $user->id,
            'rating'  => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return $this->successResponse(
            $review->load('user:id,name'),
            'Review submitted successfully.',
            201
        );
    }
}
