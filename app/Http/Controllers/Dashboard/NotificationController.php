<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Notification;
use App\Broadcasting\PusherChannel;
use App\Models\Notification as NotificationModel;
use App\Notifications\CustomNotification;
use Laraeast\LaravelSettings\Facades\Settings;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.notifications.index');
    }
    public function certain()
    {
        $users  =   User::query()
            ->whereIn('type', [User::CUSTOMER_TYPE])
            ->get();
        return view('dashboard.notifications.show',
            [
                'users'     => $users->where('type', User::CUSTOMER_TYPE),
            ]);
    }

    /**
     * Show the form for creating aew resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $users = user::where('type',$request->user_type)->get();
        
        foreach ($users as $user){
            Notification::send($user, new CustomNotification([
                'via' => ['database', PusherChannel::class],
                'database' => [
                    'trans' => 'notifications.admin_notification',
                    'user_id' => $user->id,
                    'type' => NotificationModel::ADMIN_TYPE,
                    'id' => $user->id,
                ],
                'fcm' => [
                    'title' => $request->input('title'),
                    'body' => $request->input('body'),
                    'type' => NotificationModel::ADMIN_TYPE,
                    'data' => [
                        'id' => $user->id,
                    ],
                ],
            ]));
        }
        flash()->success(trans('notifications.messages.sent'));
        return redirect()->back();
      
        }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
