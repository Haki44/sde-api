<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdventureBookingNotification extends Notification
{
    use Queueable;

    public $data;
    public $adventure;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data, $adventure)
    {
        $this->data = $data;
        $this->adventure = $adventure;
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
                    ->markdown('emails.request-adventure', ['data' => $this->data, 'adventure' => $this->adventure])
                    ->subject('Une nouvelle demande de reservation pour une aventure');
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
