<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Support\Date;
use App\Models\ShopOrder;
use Illuminate\Http\Request;
use App\Events\OrderAccepted;
use App\Events\ShopOrderReported;
use Illuminate\Routing\Controller;
use App\Events\OrderMarkedAsDelivered;
use App\Events\OrderMarkedAsDelivering;
use App\Http\Resources\CollectResource;
use App\Http\Resources\ShopOrderResource;
use App\Events\OrderMarkedAsWaitingDeliver;
use App\Events\OrderMarkedAsAssignedToDelegate;
use App\Events\OrderMarkedAsDeliveredToDelegate;
use App\Events\OrderMarkedAsDeliveringToDelegate;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\User;
use App\Traits\NotificationsTrait;
use App\Models\Notification as NotificationModel;
use App\Models\Delegate;

class ShopOrderController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Create Order Controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');

        $this->middleware('user:shop_owner')->except([
            'index',
            'show',
            'markAsDeliveringToDelegate',
            'markAsAssignedToDelegate',
            'markAsDelivering',
            'markAsDelivered',
            'report',
            'getDelegateBalance',
            'delegateCollect',
        ]);

        $this->middleware('user:delegate')->only('markAsDelivering', 'markAsDelivered', 'getDelegateBalance', 'delegateCollect');

        $this->middleware('user:delegate,shop_owner')->only('index');
    }

    /**
     * Display a listing of the orders.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ShopOrderResource::collection(ShopOrder::filter()->with('shop.owner.city', 'order.user.city')->simplePaginate());
    }

    /**
     * Display the specified order.
     *
     * @param \App\Models\ShopOrder $shopOrder
     * @return \App\Http\Resources\ShopOrderResource
     */
    public function show(ShopOrder $shopOrder)
    {
        return new ShopOrderResource($shopOrder->load('items.product', 'shop.owner.city', 'order.user.city'));
    }

    /**
     * Display the specified order.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getBalance()
    {
        $shop = auth()->user()->shop;

        $balance = $shop->orders()->where('status', Order::DELIVERED_STATUS)->whereNull('collected_at')->sum('total');

        $collected = $shop->collects()->latest('date')->simplePaginate();

        return CollectResource::collection($collected)
            ->additional([
                'balance' => price($balance),
            ]);
    }

    /**
     * Display the specified order.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getDelegateBalance()
    {
        /** @var \App\Models\Delegate $delegate */
        $delegate = auth()->user();

        $balance = $delegate->shopOrders()->where('status', Order::DELIVERED_STATUS)->whereNull('delegate_collected_at')->sum('total');

        $collected = $delegate->collects()->latest('date')->simplePaginate();

        return CollectResource::collection($collected)
            ->additional([
                'balance' => price($balance),
            ]);
    }

    /**
     * Display the specified order.
     *
     * @return \Illuminate\Http\JsonResponse
     * @deprecated
     */
    public function collect()
    {
        auth()->user()->shop->collect();

        return response()->json([
            'message' => 'done',
        ]);
    }

    /**
     * Display the specified order.
     *
     * @return \Illuminate\Http\JsonResponse
     * @deprecated
     */
    public function delegateCollect()
    {
        auth()->user()->collect();

        return response()->json([
            'message' => 'done',
        ]);
    }

    /**
     * Mark the specified order as accepted.
     *
     * @param \App\Models\ShopOrder $shopOrder
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return \App\Http\Resources\ShopOrderResource
     */
    public function accept(ShopOrder $shopOrder)
    {
        $this->authorize('accept', $shopOrder);

        $shopOrder->forceFill([
            'status' => Order::IN_PROGRESS_STATUS,
        ])->save();

        $shopOrder->refresh()->load('items.product');

        broadcast(new OrderAccepted($shopOrder))->toOthers();

        return new ShopOrderResource($shopOrder->load('shop.owner.city', 'order.user.city'));
    }

    /**
     * Mark the specified order as waiting deliver.
     *
     * @param \App\Models\ShopOrder $shopOrder
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return \App\Http\Resources\ShopOrderResource
     */
    public function markAsWaitingDeliver(ShopOrder $shopOrder)
    {
        $this->authorize('markAsWaitingDeliver', $shopOrder);

        $shopOrder->forceFill([
            'status' => Order::WAITING_DELIVER_STATUS,
        ])->save();

        $shopOrder->refresh()->load('items.product');

        broadcast(new OrderMarkedAsWaitingDeliver($shopOrder))->toOthers();

        return new ShopOrderResource($shopOrder->load('shop.owner.city', 'order.user.city'));
    }

    /**
     * Mark the specified order as assigned to delegate.
     *
     * @param \App\Models\ShopOrder $shopOrder
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\ShopOrderResource
     */
    public function markAsAssignedToDelegate(ShopOrder $shopOrder, Request $request)
    {
        $request->validate([
            'delegate_id' => 'required|exists:users,id',
        ]);

        $shopOrder->forceFill([
            'status' => Order::ASSIGNED_TO_DELEGATE_STATUS,
            'delegate_id' => $request->delegate_id,
        ])->save();

        $shopOrder->refresh()->load('items.product');

        broadcast(new OrderMarkedAsAssignedToDelegate($shopOrder))->toOthers();

        return new ShopOrderResource($shopOrder->load('shop.owner.city', 'order.user.city'));
    }

    /**
     * Mark the specified order as delivering to delegate.
     *
     * @param \App\Models\ShopOrder $shopOrder
     * @return \App\Http\Resources\ShopOrderResource
     */
    public function markAsDeliveringToDelegate(ShopOrder $shopOrder)
    {
        $this->authorize('markAsDeliveringToDelegate', $shopOrder);

        $shopOrder->forceFill([
            'status' => Order::DELIVERING_TO_DELEGATE,
        ])->save();

        $shopOrder->refresh()->load('items.product');

        broadcast(new OrderMarkedAsDeliveringToDelegate($shopOrder))->toOthers();

        return new ShopOrderResource($shopOrder->load('shop.owner.city', 'order.user.city'));
    }

    /**
     * Mark the specified order as delivered to delegate.
     *
     * @param \App\Models\ShopOrder $shopOrder
     * @return \App\Http\Resources\ShopOrderResource
     */
    public function markAsDeliveredToDelegate(ShopOrder $shopOrder)
    {
        $this->authorize('markAsDeliveredToDelegate', $shopOrder);

        $shopOrder->forceFill([
            'status' => Order::DELIVERED_TO_DELEGATE,
        ])->save();

        $shopOrder->refresh()->load('items.product');

        broadcast(new OrderMarkedAsDeliveredToDelegate($shopOrder))->toOthers();

        return new ShopOrderResource($shopOrder->load('shop.owner.city', 'order.user.city'));
    }

    /**
     * Mark the specified order as delivering.
     *
     * @param \App\Models\ShopOrder $shopOrder
     * @return \App\Http\Resources\ShopOrderResource
     */
    public function markAsDelivering(ShopOrder $shopOrder)
    {
        $this->authorize('markAsDelivering', $shopOrder);

        $shopOrder->forceFill([
            'status' => Order::DELIVERING_STATUS,
        ])->save();

        $shopOrder->refresh()->load('items.product');

        broadcast(new OrderMarkedAsDelivering($shopOrder))->toOthers();

        return new ShopOrderResource($shopOrder->load('shop.owner.city', 'order.user.city'));
    }

    /**
     * Mark the specified order as delivered.
     *
     * @param \App\Models\ShopOrder $shopOrder
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return \App\Http\Resources\ShopOrderResource
     */
    public function markAsDelivered(ShopOrder $shopOrder)
    {
        $this->authorize('markAsDelivered', $shopOrder);

        $shopOrder->forceFill([
            'status' => Order::DELIVERED_STATUS,
        ])->save();

        $shopOrder->refresh()->load('items.product');

        $title = 'اشعار وصول شحنة جديدة';
        $body ='تم وصول شحنة لك رقم'.$shopOrder->id;
        NotificationsTrait::send($shopOrder->order->user,$title,$body,NotificationModel::Delivered_CUTOMER_TYPE,$shopOrder->id);
        if($shopOrder->order->status == 8 )
        {
            $title = 'اشعار وصول الطلب';
            $body =' تم وصول الطلب كاملا'.$shopOrder->order->id;
        NotificationsTrait::send($shopOrder->order->user,$title,$body,NotificationModel::FINSH_ORDER_TYPE,$shopOrder->order->id);
        }
        broadcast(new OrderMarkedAsDelivered($shopOrder))->toOthers();

        return new ShopOrderResource($shopOrder->load('shop.owner.city', 'order.user.city'));
    }

    /**
     * Report the specified order.
     *
     * @param \App\Models\ShopOrder $shopOrder
     * @param \Illuminate\Http\Request $request
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return \Illuminate\Http\JsonResponse
     */
    public function report(ShopOrder $shopOrder, Request $request)
    {
        $this->authorize('report', $shopOrder);

        $request->validate(['message' => 'required'], [], trans('reports.attributes'));

        $report = $shopOrder->reports()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        broadcast(new ShopOrderReported($report))->toOthers();

        return response()->json([
            'message' => trans('reports.messages.sent'),
        ]);
    }
}
