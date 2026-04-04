<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = ['product_id', 'sku', 'size', 'color', 'stock', 'price_adjustment'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
