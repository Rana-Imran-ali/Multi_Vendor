<?php

namespace App\Listeners;

use App\Events\OrderStatusUpdated;
use App\Notifications\OrderStatusChangedNotification;

class SendOrderStatusUpdatedNotification
{
    public function handle(OrderStatusUpdated $event): void
    {
        $event->order->user->notify(new OrderStatusChangedNotification($event->order, $event->previousStatus));
    }
}
