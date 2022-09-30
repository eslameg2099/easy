<?php

namespace App\Broadcasting;
use App\Models\User;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;
use Pusher\PushNotifications\PushNotifications;

class PusherChannel
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
        if (! method_exists($notification, 'toPusher')) {
            throw new \Exception('method "toPusher" not found in "'.get_class($notification).'"');
        }

        $data = $notification->toPusher($notifiable) ;

        $this->getPushNotifications($notifiable->type)
            ->publishToUsers($this->getInterests($notifiable, $notifiable), [
                "fcm" => [
                    "notification" => $data,
                    "data" => $data,
                ],
                "apns" => [
                    "aps" => [
                        "alert" => $data
                    ]
                ],
            ]);
    }

    /**
     * Get the interests of the notification.
     *
     * @param $notifiable
     * @param $notification
     * @return \Illuminate\Support\Collection|mixed|string[]
     */
    protected function getInterests($notifiable, $notification)
    {
        $interests = collect(Arr::wrap($notifiable->routeNotificationFor('PusherNotification')))
            ->map(function ($interest) {
                return (string) $interest;
            })->toArray();

        return method_exists($notification, 'pusherInterests')
            ? $notification->pusherInterests($notifiable)
            : ($interests ?: ["{$notifiable->id}"]);
    }

    /**
     * Create PushNotification instance.
     *
     * @throws \Exception
     * @return \Pusher\PushNotifications\PushNotifications
     */
    protected function getPushNotifications($type): PushNotifications
    {
        $config = config('services.pusher');
        switch ($type)
        {
            case User::CUSTOMER_TYPE:
                return new PushNotifications([
                    'instanceId' => '9d89c0cb-dfb0-4b47-a841-1a73c16d9114',
                    'secretKey' => '370F68752EF850EF7512E9834812A5B417F84D97A9DEE3EF3F87740D310938AA',
                ]);

            case User::SHOP_OWNER_TYPE:
                return new PushNotifications([
                    'instanceId' => 'ac56fc82-5def-4cf9-bee2-d3ac911c4dcd',
                    'secretKey' => '4C36E47A6BEF555D0BE72CFB1B8219DFA16F741A789971E474F45A24EE15A63F',
                ]);

                case User::DELEGATE_TYPE:
                    return new PushNotifications([
                        'instanceId' => '827cd82c-b720-42f2-937c-960544531d28',
                        'secretKey' => 'DDB06C4D3014703EA556D270807144542190EF906065E5F9E07370D90651C678',
                    ]);

        }


     
    }
}
