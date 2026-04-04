<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WishlistResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'wishlist_id'  => $this->id,
            'product'      => [
                'id'          => $this->product->id,
                'name'        => $this->product->name,
                'slug'        => $this->product->slug,
                'price'       => $this->product->price,
                'category'    => $this->product->category?->name,
                'thumbnail'   => optional($this->product->images->first())->url,
                'in_stock'    => $this->product->stock > 0,
                'status'      => $this->product->status,
            ],
            'wishlisted_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
