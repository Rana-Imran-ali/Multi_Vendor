<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\WishlistResource;
use App\Services\WishlistService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
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

        return response()->json([
            'status' => 'success',
            'count'  => $items->count(),
            'data'   => WishlistResource::collection($items),
        ]);
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

        $status  = $created ? 201 : 200;
        $message = $created ? 'Product added to wishlist.' : 'Product is already in your wishlist.';

        return response()->json([
            'status'  => 'success',
            'message' => $message,
            'data'    => new WishlistResource($item),
        ], $status);
    }

    // ─── DELETE /api/wishlist/{product} ──────────────────────────────────────
    /**
     * Remove a product from the wishlist by product ID.
     */
    public function remove(Request $request, int $productId): JsonResponse
    {
        $removed = $this->wishlistService->remove($request->user(), $productId);

        if (! $removed) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Product not found in your wishlist.',
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Product removed from wishlist.',
        ]);
    }

    // ─── GET /api/wishlist/{product}/check ───────────────────────────────────
    /**
     * Check if a product is in the authenticated user's wishlist.
     * Useful for toggling UI heart icons without fetching the full list.
     */
    public function check(Request $request, int $productId): JsonResponse
    {
        $inWishlist = $this->wishlistService->has($request->user(), $productId);

        return response()->json([
            'status'      => 'success',
            'in_wishlist' => $inWishlist,
        ]);
    }
}
