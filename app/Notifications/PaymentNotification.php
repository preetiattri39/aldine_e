<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentNotification extends Notification
{
    use Queueable;

    protected $full_name , $amount, $order_id;
    /**
     * Create a new notification instance.
     */
    public function __construct($full_name,$amount,$order_id)
    {
        $this->full_name    = $full_name;
        $this->amount       = $amount;
        $this->order_id     = $order_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type'       => "payment_paid",
            'title'      => "Payment Paid Successfully",
            'description'=> $this->full_name." paid $".$this->amount." for ".$this->order_id." been  successfully.",
            'route'      => route('admin.transaction.list')
        ];
    }
}
