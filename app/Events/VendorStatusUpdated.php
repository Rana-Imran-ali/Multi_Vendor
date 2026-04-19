<?php

namespace App\Events;

use App\Models\Vendor;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VendorStatusUpdated
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly Vendor $vendor,
        public readonly string $decision
    ) {}
}
