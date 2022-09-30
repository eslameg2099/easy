<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\Order;
use App\Models\ShopOrder;
use App\Notifications\Channels\PusherChannel;
use App\Notifications\CustomNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Laraeast\LaravelSettings\Facades\Settings;

class OrderCreatedListener
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
     * @param  OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $event->order->shopOrders()->each(function (ShopOrder $shopOrder) use ($event) {
            Notification::send($event->offer->order->Delegate, new CustomNotification([
                'via' => ['database', PusherChannel::class],
                'database' => [
                    'trans' => 'notifications.order-created',
                    'user_id' => $event->order->user_id,
                    'order_id' => $event->order->id,
                    'offer_id' => $event->offer->id,
                    'type' => $event->offer->order->type == Order::Delivery
                        ? NotificationModel::DELIVERED_ORDER_TYPE
                        : NotificationModel::PURCHASE_ORDER_TYPE,
                    'id' => $event->offer->order_id,
                ],
                'fcm' => [
                    'title' => Settings::get('name', 'Fetch App'),
                    'body' => trans('notifications.user.accept_offer', [
                        'user' => $event->offer->order->User->name,
                        'order' => '#' . $event->offer->order_id,
                    ]),
                    'type' => $event->offer->order->type == Order::Delivery
                        ? NotificationModel::DELIVERED_ORDER_TYPE
                        : NotificationModel::PURCHASE_ORDER_TYPE,
                    'data' => [
                        'id' => $event->offer->order_id,
                    ],
                ],
            ]));
        });
    }
}
