<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AcceptedBoatBookingNotification extends Notification
{
    use Queueable;

    public $boat_booking;
    public $user_to;
    public $boat;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($boat_booking, $user_to, $boat)
    {
        $this->boat_booking = $boat_booking;
        $this->user_to = $user_to;
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
                    ->from('renan@example.com', 'Sailing dream experience')
                    ->markdown('emails.accepted-request-boat', ['boat_booking' => $this->boat_booking, 'user_to' => $this->user_to, 'boat' => $this->boat])
                    ->subject('Votre demande de location de bateau à été acceptée !');
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
