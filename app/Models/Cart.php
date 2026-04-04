<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id'];

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // ─── Computed Attributes ───────────────────────────────────────────────────

    /**
     * Total item count across all lines.
     */
    public function getTotalQuantityAttribute(): int
    {
        return $this->items->sum('quantity');
    }

    /**
     * Grand total based on unit_price snapshot × quantity.
     */
    public function getSubtotalAttribute(): float
    {
        return (float) array_sum(
            array_map(
                static fn ($item) => $item->unit_price * $item->quantity,
                $this->items->all()
            )
        );
    }
}
