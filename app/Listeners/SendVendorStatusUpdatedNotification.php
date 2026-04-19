<?php

namespace App\Listeners;

use App\Events\VendorStatusUpdated;
use App\Notifications\VendorApprovedNotification;

class SendVendorStatusUpdatedNotification
{
    public function handle(VendorStatusUpdated $event): void
    {
        $event->vendor->user->notify(new VendorApprovedNotification($event->vendor, $event->decision));
    }
}
