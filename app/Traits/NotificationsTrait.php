<?php


namespace App\Traits;


use Illuminate\Support\Facades\Notification;
use App\Broadcasting\PusherChannel;
use App\Models\Notification as NotificationModel;
use App\Notifications\CustomNotification;
use Laraeast\LaravelSettings\Facades\Settings;
use App\Models\User;


trait NotificationsTrait
{

  public static function send(user $user,$title,$body,$type,$operation_id)
  {
    Notification::send($user, new CustomNotification([
        'via' => ['database', PusherChannel::class],
        'database' => [
            'trans' => 'notifications.admin_notification',
            'user_id' => $user->id,
            'type' => $type,
            'id' => $operation_id,
        ],
        'fcm' => [
            'title' => $title,
            'body' => $body,
            'type' => $type,
            'data' => [
                'id' => $operation_id,
            ],
        ],
    ]));

  }



}
