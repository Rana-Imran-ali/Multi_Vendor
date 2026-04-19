<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Review extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'reviewable_id',
        'reviewable_type',
        'title',
        'rating',
        'comment',
        'status',
        'helpful_count',
    ];

    protected $casts = [
        'rating'        => 'integer',
        'helpful_count' => 'integer',
    ];

    // ── Relationships ─────────────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewable()
    {
        return $this->morphTo();
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    /** Only reviews visible to the public. */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    /** Reviews ordered by most helpful first. */
    public function scopeMostHelpful(Builder $query): Builder
    {
        return $query->orderByDesc('helpful_count');
    }

    /** Reviews for a specific star rating. */
    public function scopeByRating(Builder $query, int $stars): Builder
    {
        return $query->where('rating', $stars);
    }

    // ── Static helpers ────────────────────────────────────────────────────────

    /**
     * Compute full rating summary for any reviewable model.
     * Returns: average, total_count, and per-star breakdown.
     */
    public static function summaryFor(Model $reviewable): array
    {
        $reviews = $reviewable->reviews()->approved()->get();

        $total   = $reviews->count();
        $average = $total > 0 ? round($reviews->avg('rating'), 2) : 0;

        $breakdown = collect([5, 4, 3, 2, 1])->mapWithKeys(function (int $star) use ($reviews, $total) {
            $count      = $reviews->where('rating', $star)->count();
            $percentage = $total > 0 ? round(($count / $total) * 100) : 0;
            return [$star => ['count' => $count, 'percentage' => $percentage]];
        })->all();

        return [
            'average'   => $average,
            'total'     => $total,
            'breakdown' => $breakdown,
        ];
    }
}
