<?php

namespace App\Notifications;

use App\Models\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VendorApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly Vendor $vendor,
        public readonly string $decision // 'approved' | 'rejected'
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        if ($this->decision === 'approved') {
            return (new MailMessage)
                ->subject("Congratulations — Your Vendor Application is Approved!")
                ->greeting("Hello {$notifiable->name},")
                ->line("Your application for **{$this->vendor->store_name}** has been approved.")
                ->line('You can now list products and start selling on our platform.')
                ->action('Go to Vendor Dashboard', url('/vendor/dashboard'))
                ->line('Welcome to the marketplace!');
        }

        return (new MailMessage)
            ->subject("Vendor Application Update — {$this->vendor->store_name}")
            ->greeting("Hello {$notifiable->name},")
            ->line("Unfortunately your vendor application for **{$this->vendor->store_name}** has been rejected.")
            ->when($this->vendor->rejection_reason, fn($mail) =>
                $mail->line("**Reason:** {$this->vendor->rejection_reason}")
            )
            ->line('You may re-apply after addressing the concerns above.')
            ->action('Contact Support', url('/contact'))
            ->line('Thank you for your interest.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'       => 'vendor_application_' . $this->decision,
            'vendor_id'  => $this->vendor->id,
            'store_name' => $this->vendor->store_name,
            'decision'   => $this->decision,
            'message'    => "Your vendor application for {$this->vendor->store_name} has been {$this->decision}.",
        ];
    }
}
