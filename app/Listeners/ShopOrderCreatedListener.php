<?php

namespace App\Listeners;
use App\Models\User;

use App\Events\ShopOrderCreated;
use App\Models\ShopOrder;
use App\Notifications\Channels\PusherChannel;
use App\Notifications\CustomNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Laraeast\LaravelSettings\Facades\Settings;

use App\Models\Order;

class ShopOrderCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ShopOrderCreated  $event
     * @return void
     */
    public function handle(ShopOrderCreated $event)
    {
        Notification::send($event->shop->owner, new CustomNotification([
            'via' => ['database', PusherChannel::class],
            'database' => [
                'trans' => 'notifications.order-created',
                'user_id' =>$event->shop->owner->id,
                'order_id' => $event->order->id,
                'type' =>"hg",
                'id' => $event->order->id,
            ],
            'fcm' => [
                'title' => Settings::get('name', 'Fetch App'),
                'body' => trans('notifications.user.accept_offer', [
                    'user' => $event->order->id,
                    'order' => '#' . $event->order->id,
                ]),
                'type' =>"hg",

                'data' => [
                    'id' => $event->order->id,
                ],
            ],
        ]));
    }


   
}
