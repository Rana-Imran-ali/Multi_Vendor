<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly Order  $order,
        public readonly string $previousStatus
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $statusLabel = ucfirst($this->order->status);

        $message = (new MailMessage)
            ->subject("Order #{$this->order->order_number} is now {$statusLabel}")
            ->greeting("Hello {$notifiable->name},")
            ->line("Your order **#{$this->order->order_number}** status has been updated.")
            ->line("**Previous Status:** " . ucfirst($this->previousStatus))
            ->line("**New Status:** {$statusLabel}");

        if ($this->order->status === 'shipped') {
            $message->line('Your order is on its way!');
        } elseif ($this->order->status === 'delivered') {
            $message->line('Your order has been delivered. Enjoy!');
        } elseif ($this->order->status === 'cancelled') {
            $message->line('Your order has been cancelled. Contact support if this was unexpected.');
        }

        return $message
            ->action('View Order', url("/user/orders/{$this->order->id}"))
            ->line('Thank you for shopping with us!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'            => 'order_status_changed',
            'order_id'        => $this->order->id,
            'order_number'    => $this->order->order_number,
            'previous_status' => $this->previousStatus,
            'new_status'      => $this->order->status,
            'message'         => "Order #{$this->order->order_number} is now {$this->order->status}.",
        ];
    }
}
