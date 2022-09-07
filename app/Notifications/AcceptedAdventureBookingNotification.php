<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AcceptedAdventureBookingNotification extends Notification
{
    use Queueable;

    public $adventure_booking;
    public $user_to;
    public $adventure;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($adventure_booking, $user_to, $adventure)
    {
        $this->adventure_booking = $adventure_booking;
        $this->user_to = $user_to;
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
                    ->from('renan@example.com', 'Sailing dream experience')
                    ->markdown('emails.accepted-request-adventure', ['adventure_booking' => $this->adventure_booking, 'user_to' => $this->user_to, 'adventure' => $this->adventure])
                    ->subject('La demande pour votre croisière à été acceptée !');
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
