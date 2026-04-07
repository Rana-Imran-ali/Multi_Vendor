<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'code',
        'discount_type',
        'discount_amount',
        'min_spend',
        'max_uses',
        'max_uses_per_user',
        'used_count',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'discount_amount'   => 'float',
        'min_spend'         => 'float',
        'is_active'         => 'boolean',
        'expires_at'        => 'datetime',
        'used_count'        => 'integer',
        'max_uses'          => 'integer',
        'max_uses_per_user' => 'integer',
    ];

    // ── Relationships ──────────────────────────────────────────────────────────

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function usages()
    {
        return $this->hasMany(CouponUsage::class);
    }

    // ── Scopes ─────────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(fn($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>', now()));
    }
}
