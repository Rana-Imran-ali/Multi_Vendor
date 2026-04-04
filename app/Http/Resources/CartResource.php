<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'items'          => CartItemResource::collection($this->items),
            'total_quantity' => $this->total_quantity,
            'subtotal'       => number_format($this->subtotal, 2, '.', ''),
            'updated_at'     => $this->updated_at->toDateTimeString(),
        ];
    }
}
