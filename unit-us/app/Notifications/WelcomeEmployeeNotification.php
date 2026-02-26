<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeEmployeeNotification extends Notification
{
    protected $password;
    protected $slug;

    public function __construct($password, $slug)
    {
        $this->password = $password;
        $this->slug = $slug;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $welcomeUrl = config('app.url') . '/' . $this->slug . '/welcome';

        return (new MailMessage)
            ->subject('Welcome to Unit-Us!')
            ->greeting('Hello!')
            ->line('You have been added to your company dashboard.')
            ->line('Your temporary password is: **' . $this->password . '**')
            ->action('Set Your New Password', $welcomeUrl)
            ->line('Click the button above and use your temporary password to create a new one.')
            ->salutation('Regards,');
    }
}