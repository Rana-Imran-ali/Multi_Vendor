<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlacedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly Order $order) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Order Confirmed — #{$this->order->order_number}")
            ->greeting("Hello {$notifiable->name},")
            ->line("Your order **#{$this->order->order_number}** has been placed successfully.")
            ->line("**Total:** \${$this->order->total_amount}")
            ->line("We'll notify you as your order progresses.")
            ->action('View Order', url("/user/orders/{$this->order->id}"))
            ->line('Thank you for shopping with us!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'         => 'order_placed',
            'order_id'     => $this->order->id,
            'order_number' => $this->order->order_number,
            'total_amount' => $this->order->total_amount,
            'message'      => "Your order #{$this->order->order_number} has been placed.",
        ];
    }
}
