<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CartService
{
    /**
     * Retrieve (or lazily create) a user's cart.
     */
    public function getOrCreateCart(User $user): Cart
    {
        return Cart::firstOrCreate(['user_id' => $user->id]);
    }

    /**
     * Fetch the cart with all eager-loaded relations needed for the response.
     */
    public function getCartWithDetails(User $user): Cart
    {
        $cart = $this->getOrCreateCart($user);

        // Eager-load items → product → images and category for a rich response
        $cart->load([
            'items.product.images',
            'items.product.category:id,name',
        ]);

        return $cart;
    }

    /**
     * Add a product to the cart, merging quantity if the product already exists.
     * Performs a stock check against the *combined* quantity (existing + new).
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addItem(User $user, int $productId, int $quantity): CartItem
    {
        return DB::transaction(function () use ($user, $productId, $quantity) {
            $product = Product::where('id', $productId)
                              ->where('status', 'active')
                              ->lockForUpdate()
                              ->firstOrFail();

            $cart = $this->getOrCreateCart($user);

            $item = CartItem::firstOrNew([
                'cart_id'    => $cart->id,
                'product_id' => $productId,
            ]);

            $newQty = ($item->exists ? $item->quantity : 0) + $quantity;

            if ($product->stock < $newQty) {
                abort(422, "Only {$product->stock} unit(s) available in stock.");
            }

            $item->quantity   = $newQty;
            $item->unit_price = $product->price; // snapshot current price
            $item->save();

            return $item->load('product.images');
        });
    }

    /**
     * Update the quantity of an existing cart item.
     */
    public function updateQuantity(CartItem $item, int $quantity): CartItem
    {
        return DB::transaction(function () use ($item, $quantity) {
            $product = Product::where('id', $item->product_id)
                               ->lockForUpdate()
                               ->firstOrFail();

            if ($product->stock < $quantity) {
                abort(422, "Only {$product->stock} unit(s) available in stock.");
            }

            $item->update(['quantity' => $quantity]);

            return $item->fresh('product');
        });
    }

    /**
     * Remove a single item from the cart.
     */
    public function removeItem(CartItem $item): void
    {
        $item->delete();
    }

    /**
     * Remove all items from the user's cart.
     */
    public function clearCart(User $user): void
    {
        $cart = $this->getOrCreateCart($user);
        $cart->items()->delete();
    }

    /**
     * Ensure the given CartItem belongs to the currently authenticated user's cart.
     */
    public function authorizeItem(User $user, CartItem $item): bool
    {
        $cart = $this->getOrCreateCart($user);
        return $item->cart_id === $cart->id;
    }
}
