<?php

namespace App\Services;

use App\Models\User;
use App\Models\Wishlist;
use App\Models\Product;

class WishlistService
{
    /**
     * Get all wishlist entries for a user with product details eager-loaded.
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, Wishlist>
     */
    public function getWishlist(User $user)
    {
        return Wishlist::where('user_id', $user->id)
            ->with([
                'product.images',
                'product.category:id,name',
            ])
            ->latest()
            ->get();
    }

    /**
     * Add a product to the user's wishlist.
     * Returns the entry (existing or newly created) and a flag indicating if it was newly created.
     *
     * @return array{item: Wishlist, created: bool}
     */
    public function add(User $user, int $productId): array
    {
        // Ensure the product exists and is active
        $product = Product::where('id', $productId)
                          ->where('status', 'active')
                          ->firstOrFail();

        [$item, $created] = Wishlist::firstOrCreate([
            'user_id'    => $user->id,
            'product_id' => $product->id,
        ]);

        // Eager-load if newly created
        if ($created) {
            $item->load(['product.images', 'product.category:id,name']);
        }

        return ['item' => $item, 'created' => $created];
    }

    /**
     * Remove a product from the user's wishlist.
     * Returns true if removed, false if it didn't exist.
     */
    public function remove(User $user, int $productId): bool
    {
        $deleted = Wishlist::where('user_id', $user->id)
                           ->where('product_id', $productId)
                           ->delete();

        return $deleted > 0;
    }

    /**
     * Check whether a product is on the user's wishlist.
     */
    public function has(User $user, int $productId): bool
    {
        return Wishlist::where('user_id', $user->id)
                       ->where('product_id', $productId)
                       ->exists();
    }
}
