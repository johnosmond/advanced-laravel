<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClassCancelledNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Array $details)
    {
        //
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
        $line1 = "Sorry to inform you but your {$this->details['className']} class on {$this->details['classDateTime']->format('jS F')} at {$this->details['classDateTime']->format('g:i a')} was cancelled.";

        return (new MailMessage)
                    ->subject('Sorry, your class was cancelled.')
                    ->greeting('Hello ' . $notifiable->name)
                    ->line($line1)
                    ->line('Please check the schedule to book another class.')
                    ->action('Book a Class', url('/member/book'))
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
            //
        ];
    }
}
