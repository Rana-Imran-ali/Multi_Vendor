<?php

namespace App\Observers;

use App\Models\Review;
use Illuminate\Support\Facades\Cache;

class ReviewObserver
{
    /**
     * When a review is created, the avg_rating for its product changes.
     * Bust the product's individual cache so the next read recalculates.
     */
    public function created(Review $review): void
    {
        Cache::forget("product:{$review->product_id}");
    }

    /**
     * Same on update or delete.
     */
    public function updated(Review $review): void
    {
        Cache::forget("product:{$review->product_id}");
    }

    public function deleted(Review $review): void
    {
        Cache::forget("product:{$review->product_id}");
    }
}
