<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartItemResource;
use App\Http\Resources\CartResource;
use App\Models\CartItem;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private readonly CartService $cartService)
    {
    }

    // ─── GET /api/cart ────────────────────────────────────────────────────────
    /**
     * Return the authenticated user's full cart with product details.
     */
    public function index(Request $request): JsonResponse
    {
        $cart = $this->cartService->getCartWithDetails($request->user());

        return response()->json([
            'status' => 'success',
            'data'   => new CartResource($cart),
        ]);
    }

    // ─── POST /api/cart ───────────────────────────────────────────────────────
    /**
     * Add a product to the cart (merges quantity if already present).
     */
    public function add(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity'   => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        $item = $this->cartService->addItem(
            $request->user(),
            $validated['product_id'],
            $validated['quantity']
        );

        return response()->json([
            'status'  => 'success',
            'message' => 'Item added to cart.',
            'data'    => new CartItemResource($item),
        ], 201);
    }

    // ─── PUT /api/cart/{cartItem} ─────────────────────────────────────────────
    /**
     * Update the quantity of a specific cart line item.
     */
    public function updateQuantity(Request $request, CartItem $cartItem): JsonResponse
    {
        $this->requireOwnership($request, $cartItem);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        $item = $this->cartService->updateQuantity($cartItem, $validated['quantity']);

        return response()->json([
            'status'  => 'success',
            'message' => 'Cart item updated.',
            'data'    => new CartItemResource($item),
        ]);
    }

    // ─── DELETE /api/cart/{cartItem} ─────────────────────────────────────────
    /**
     * Remove a single item from the cart.
     */
    public function remove(Request $request, CartItem $cartItem): JsonResponse
    {
        $this->requireOwnership($request, $cartItem);

        $this->cartService->removeItem($cartItem);

        return response()->json([
            'status'  => 'success',
            'message' => 'Item removed from cart.',
        ]);
    }

    // ─── DELETE /api/cart ─────────────────────────────────────────────────────
    /**
     * Clear all items from the cart.
     */
    public function clear(Request $request): JsonResponse
    {
        $this->cartService->clearCart($request->user());

        return response()->json([
            'status'  => 'success',
            'message' => 'Cart cleared.',
        ]);
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    /**
     * Abort with 403 if the cart item does not belong to the current user.
     */
    private function requireOwnership(Request $request, CartItem $item): void
    {
        if (! $this->cartService->authorizeItem($request->user(), $item)) {
            abort(403, 'You do not own this cart item.');
        }
    }
}
