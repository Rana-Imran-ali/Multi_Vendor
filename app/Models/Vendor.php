<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Model
{
    use HasFactory;

    // Status constants — use these everywhere instead of magic strings
    const STATUS_PENDING  = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'user_id',
        'store_name',
        'slug',
        'description',
        'logo',
        'status',
        'rejection_reason',
    ];

    /**
     * The user who owns this vendor profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Products listed by this vendor.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Reviews left for this vendor.
     */
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    /** Only publicly approved reviews. */
    public function approvedReviews()
    {
        return $this->morphMany(Review::class, 'reviewable')->where('status', 'approved');
    }

    /** Average star rating across approved reviews. */
    public function getAverageRatingAttribute(): float
    {
        return round((float) $this->approvedReviews()->avg('rating'), 2);
    }

    /**
     * Scope: only pending vendor applications.
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope: only approved vendors.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    /**
     * Helper to check approval state.
     */
    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }
}
