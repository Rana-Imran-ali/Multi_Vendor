<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Placeholder Order model.
 * Full implementation is handled by the Orders feature.
 */
class Order extends Model
{
    protected $fillable = ['user_id', 'status', 'total'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
