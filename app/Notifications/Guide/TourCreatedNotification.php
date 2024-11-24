<?php

namespace App\Notifications\Guide;

use App\Models\Tour;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TourCreatedNotification extends Notification
{
    use Queueable;

    private Tour $tour;

    /**
     * Create a new notification instance.
     */
    public function __construct(Tour $tour)
    {
        $this->tour = $tour;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->greeting('Hi '. $notifiable->name)
                    ->subject('Tour created')
                    ->line('Your tour has been created successfully.')
                    ->line('It will be published soon.')
                    ->line('Thank you!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
