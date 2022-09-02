<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BoatBookingNotification extends Notification
{
    use Queueable;

    public $data;
    public $boat;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data, $boat)
    {
        $this->data = $data;
        $this->boat = $boat;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->from('renan@example.com', 'Renan Leclerck')
                    ->markdown('emails.request-rental-boat', ['data' => $this->data, 'boat' => $this->boat])
                    ->subject('Une nouvelle demande de reservation pour une location de bateau');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
