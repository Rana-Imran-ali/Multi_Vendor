<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['cart_id', 'product_id', 'quantity', 'unit_price'];

    protected $casts = [
        'unit_price' => 'float',
        'quantity'   => 'integer',
    ];

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // ─── Computed Attributes ───────────────────────────────────────────────────

    /**
     * Line total = unit_price × quantity.
     */
    public function getLineTotalAttribute(): float
    {
        return $this->unit_price * $this->quantity;
    }
}
