<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\WishlistResource;
use App\Services\WishlistService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    use ApiResponse;

    public function __construct(private readonly WishlistService $wishlistService)
    {
    }

    // ─── GET /api/wishlist ────────────────────────────────────────────────────
    /**
     * Return the authenticated user's full wishlist with product details.
     */
    public function index(Request $request): JsonResponse
    {
        $items = $this->wishlistService->getWishlist($request->user());

        return $this->successResponse([
            'count' => $items->count(),
            'items' => WishlistResource::collection($items),
        ], 'Wishlist retrieved successfully.');
    }

    // ─── POST /api/wishlist ───────────────────────────────────────────────────
    /**
     * Add a product to the wishlist. Idempotent — adding again returns 200.
     */
    public function add(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
        ]);

        ['item' => $item, 'created' => $created] = $this->wishlistService->add(
            $request->user(),
            $validated['product_id']
        );

        $code    = $created ? 201 : 200;
        $message = $created ? 'Product added to wishlist.' : 'Product is already in your wishlist.';

        return $this->successResponse(new WishlistResource($item), $message, $code);
    }

    // ─── DELETE /api/wishlist/{product} ──────────────────────────────────────
    /**
     * Remove a product from the wishlist by product ID.
     */
    public function remove(Request $request, int $productId): JsonResponse
    {
        $removed = $this->wishlistService->remove($request->user(), $productId);

        if (! $removed) {
            return $this->errorResponse('Product not found in your wishlist.', 404);
        }

        return $this->successResponse(null, 'Product removed from wishlist.');
    }

    // ─── GET /api/wishlist/{product}/check ───────────────────────────────────
    /**
     * Check if a product is in the authenticated user's wishlist.
     * Useful for toggling UI heart icons without fetching the full list.
     */
    public function check(Request $request, int $productId): JsonResponse
    {
        $inWishlist = $this->wishlistService->has($request->user(), $productId);

        return $this->successResponse(['in_wishlist' => $inWishlist], 'Wishlist check complete.');
    }
}
