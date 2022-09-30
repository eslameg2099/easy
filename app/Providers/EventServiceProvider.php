<?php

namespace App\Providers;
use App\Models\User;
use App\Models\Address;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Delegate;
use App\Models\ShopOrder;
use App\Observers\OrderObserver;
use App\Observers\ShopOrderObserver;
use Illuminate\Auth\Events\Registered;
use App\Observers\ApproveDelegateObserver;
use App\Observers\PhoneVerificationObserver;
use App\Observers\AssignCategoriesToProductObserver;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Observers\AttachCitiesToUserObserver;
use App\Observers\AttachCitiesToAddressObserver;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \App\Events\FeedbackSent::class => [
            \App\Listeners\SendFeedbackMessage::class,
        ],
        \App\Events\VerificationCreated::class => [
            \App\Listeners\SendVerificationCode::class,
        ],
        \App\Events\BalanceCollected::class => [
            \App\Listeners\BalanceCollectedListener::class,
        ],
        \App\Events\DelegateApprovedEvent::class => [
            \App\Listeners\DelegateApprovedListener::class,
        ],
        \App\Events\DelegateBalanceCollected::class => [
            \App\Listeners\DelegateBalanceCollectedListener::class,
        ],
        \App\Events\OrderAccepted::class => [
            \App\Listeners\OrderAcceptedListener::class,
        ],
        \App\Events\OrderCreated::class => [
            \App\Listeners\OrderCreatedListener::class,
        ],
        \App\Events\OrderMarkedAsAssignedToDelegate::class => [
            \App\Listeners\OrderMarkedAsAssignedToDelegateListener::class,
        ],
        \App\Events\OrderMarkedAsDelivered::class => [
            \App\Listeners\OrderMarkedAsDeliveredListener::class,
        ],
        \App\Events\OrderMarkedAsDeliveredToDelegate::class => [
            \App\Listeners\OrderMarkedAsDeliveredToDelegateListener::class,
        ],
        \App\Events\OrderMarkedAsDelivering::class => [
            \App\Listeners\OrderMarkedAsDeliveringListener::class,
        ],
        \App\Events\OrderMarkedAsDeliveringToDelegate::class => [
            \App\Listeners\OrderMarkedAsDeliveringToDelegateListener::class,
        ],
        \App\Events\OrderMarkedAsWaitingDeliver::class => [
            \App\Listeners\OrderMarkedAsWaitingDeliverListener::class,
        ],
        \App\Events\ProductCreated::class => [
            \App\Listeners\ProductCreatedListener::class,
        ],
        \App\Events\ProductLocked::class => [
            \App\Listeners\ProductLockedListener::class,
        ],
        \App\Events\ProductUnlocked::class => [
            \App\Listeners\ProductUnlockedListener::class,
        ],
        \App\Events\ProductUpdated::class => [
            \App\Listeners\ProductUpdatedListener::class,
        ],
        \App\Events\ShopOrderCreated::class => [
            \App\Listeners\ShopOrderCreatedListener::class,
        ],
        \App\Events\ShopOrderReported::class => [
            \App\Listeners\ShopOrderReportedListener::class,
        ],
        \App\Events\UpdateDelegateLocation::class => [
            \App\Listeners\UpdateDelegateLocationListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();



        Customer::observe(PhoneVerificationObserver::class);
        Delegate::observe(ApproveDelegateObserver::class);
        Product::observe(AssignCategoriesToProductObserver::class);
        Order::observe(OrderObserver::class);
        ShopOrder::observe(ShopOrderObserver::class);
        User::observe(AttachCitiesToUserObserver::class);
        Address::observe(AttachCitiesToAddressObserver::class);

        
    }
}
