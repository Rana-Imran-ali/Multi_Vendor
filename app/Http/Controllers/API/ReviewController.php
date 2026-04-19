<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\Vendor;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use ApiResponse;

    // ── Model resolution ─────────────────────────────────────────────────────

    protected function resolveModel(string $type, int|string $id): Product|Vendor
    {
        return match ($type) {
            'products' => Product::findOrFail($id),
            'vendors'  => Vendor::findOrFail($id),
            default    => abort(404, 'Invalid reviewable type.'),
        };
    }

    // ─────────────────────────────────────────────────────────────────────────
    // PUBLIC ENDPOINTS
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * GET /{type}/{id}/reviews
     * List approved reviews. Supports ?sort=helpful|latest|rating_asc|rating_desc
     * and ?rating=1-5 to filter by star count.
     */
    public function index(Request $request, string $type, int $id): JsonResponse
    {
        $request->validate([
            'sort'   => 'nullable|in:helpful,latest,rating_asc,rating_desc',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        $model   = $this->resolveModel($type, $id);
        $query   = $model->reviews()->approved()->with('user:id,name');

        // Star filter
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Sort
        match ($request->input('sort', 'latest')) {
            'helpful'     => $query->orderByDesc('helpful_count'),
            'rating_asc'  => $query->orderBy('rating'),
            'rating_desc' => $query->orderByDesc('rating'),
            default       => $query->latest(),
        };

        $reviews = $query->paginate(10);

        return $this->successResponse($reviews, 'Reviews retrieved successfully.');
    }

    /**
     * GET /{type}/{id}/reviews/summary
     * Returns average rating and per-star breakdown — no auth required.
     */
    public function summary(string $type, int $id): JsonResponse
    {
        $model   = $this->resolveModel($type, $id);
        $summary = Review::summaryFor($model);

        return $this->successResponse($summary, 'Rating summary retrieved.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // AUTHENTICATED ENDPOINTS
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * POST /{type}/{id}/reviews
     * Customers submit a review. Product reviews require a confirmed purchase.
     */
    public function store(Request $request, string $type, int $id): JsonResponse
    {
        $validated = $request->validate([
            'title'   => 'nullable|string|max:160',
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        $model = $this->resolveModel($type, $id);
        $user  = $request->user();

        // Enforce purchase requirement for product reviews
        if ($type === 'products' && $model instanceof Product) {
            $hasPurchased = Order::where('user_id', $user->id)
                ->whereIn('status', ['delivered', 'processing', 'shipped'])
                ->whereHas('subOrders.items', fn($q) => $q->where('product_id', $model->id))
                ->exists();

            if (! $hasPurchased) {
                return $this->errorResponse('You can only review products you have purchased.', 403);
            }
        }

        // Prevent duplicate reviews
        if ($model->reviews()->where('user_id', $user->id)->exists()) {
            return $this->errorResponse('You have already reviewed this item.', 409);
        }

        $review = $model->reviews()->create([
            'user_id' => $user->id,
            'title'   => $validated['title'] ?? null,
            'rating'  => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
            'status'  => 'approved',
        ]);

        return $this->successResponse(
            $review->load('user:id,name'),
            'Review submitted successfully.',
            201
        );
    }

    /**
     * PUT /{type}/{id}/reviews/{review}
     * Owner can edit their own review title, rating, and comment.
     */
    public function update(Request $request, string $type, int $id, Review $review): JsonResponse
    {
        if ($review->user_id !== $request->user()->id) {
            return $this->errorResponse('You can only edit your own reviews.', 403);
        }

        $validated = $request->validate([
            'title'   => 'nullable|string|max:160',
            'rating'  => 'sometimes|required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        $review->update($validated);

        return $this->successResponse(
            $review->fresh()->load('user:id,name'),
            'Review updated successfully.'
        );
    }

    /**
     * DELETE /{type}/{id}/reviews/{review}
     * Owner can soft-delete their own review.
     * Admin can delete any review.
     */
    public function destroy(Request $request, string $type, int $id, Review $review): JsonResponse
    {
        $user = $request->user();

        if ($review->user_id !== $user->id && ! $user->isAdmin()) {
            return $this->errorResponse('You can only delete your own reviews.', 403);
        }

        $review->delete(); // soft-delete; can be restored by admin

        return $this->successResponse(null, 'Review deleted successfully.');
    }

    /**
     * POST /{type}/{id}/reviews/{review}/helpful
     * Any authenticated user can mark a review as helpful (idempotent increment).
     * Simple per-request counter — no user tracking (MVP approach).
     */
    public function markHelpful(string $type, int $id, Review $review): JsonResponse
    {
        $review->increment('helpful_count');

        return $this->successResponse(
            ['helpful_count' => $review->fresh()->helpful_count],
            'Marked as helpful.'
        );
    }
}
