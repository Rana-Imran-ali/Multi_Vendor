<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'product'    => [
                'id'        => $this->product->id,
                'name'      => $this->product->name,
                'slug'      => $this->product->slug,
                'category'  => $this->product->category?->name,
                'thumbnail' => optional($this->product->images->first())->url,
                'stock'     => $this->product->stock,
                'status'    => $this->product->status,
            ],
            'quantity'   => $this->quantity,
            'unit_price' => $this->unit_price,
            'line_total' => $this->line_total,
            'added_at'   => $this->created_at->toDateTimeString(),
        ];
    }
}
