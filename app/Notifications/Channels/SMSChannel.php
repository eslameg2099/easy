<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class SMSChannel
{
    /**
     * Send the given notification.
     *
     * @param $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @throws \Exception
     */
    public function send($notifiable, Notification $notification)
    {
        $phone = $notifiable->routeNotificationForSMS();

        $sender = config('services.hisms.sender');
        $username = config('services.hisms.username');
        $password = config('services.hisms.password');

        Http::get('https://www.hisms.ws/api.php', $data = [
            'send_sms' => '',
            'username' => $username,
            'password' => $password,
            'numbers' => $phone,
            'sender' => $sender,
            'message' => $notification->toSMS($notifiable),
        ]);
    }
}
