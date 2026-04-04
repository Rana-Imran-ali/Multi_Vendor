<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    /**
     * Auto set status to out_of_stock when stock reaches 0.
     * Also restore to active if stock is replenished.
     * Fires before any CREATE or UPDATE.
     */
    public function saving(Product $product): void
    {
        if ((int) $product->stock <= 0) {
            $product->status = 'out_of_stock';
        } elseif (
            $product->getOriginal('stock') <= 0 &&
            $product->stock > 0 &&
            $product->status === 'out_of_stock'
        ) {
            $product->status = 'active';
        }
    }

    /**
     * Bust individual product cache on update.
     */
    public function updated(Product $product): void
    {
        Cache::forget("product:{$product->id}");
    }

    /**
     * Bust individual product cache on delete.
     */
    public function deleted(Product $product): void
    {
        Cache::forget("product:{$product->id}");
    }
}
