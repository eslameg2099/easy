<?php /** @var \App\Models\Order $order */ ?>
<x-layout :title="$order->name" :breadcrumbs="['dashboard.orders.show', $order]">
    <div class="row">
        <div class="col-md-4">
            <h4>{{ trans('orders.singular') }}</h4>
            @component('dashboard::components.box')
                @slot('class', 'p-0')
                @slot('bodyClass', 'p-0')

                <table class="table table-striped table-middle">
                    <tbody>
                    <tr>
                        <th width="200">@lang('orders.attributes.id')</th>
                        <td>{{ $order->id }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('orders.attributes.status')</th>
                        <td>{{ $order->getReadableStatus() }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('orders.attributes.shop_orders_count')</th>
                        <td>{{ $order->shopOrders->count() }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('orders.attributes.user_id')</th>
                        <td>{{ $order->user->name}}</td>
                    </tr>
                    <tr>
                        <th width="200">  @lang('orders.attributes.coupon')</th>
                        <td>{{ $order->coupon->code ?? '_'}} / نسبة الخصم: {{ $order->coupon->percentage_value ?? '_'}} </td>
                    </tr>
                    <tr>
                        <th width="200">@lang('orders.attributes.total_order')</th>
                        <td>{{ price($order->total) }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('orders.attributes.shipping_cost')</th>
                        <td>{{ price($order->shipping_cost) }}</td>
                    </tr>
                    <tr>
                        <th width="200"> @lang('orders.attributes.addvalue')</th>
                        <td>{{ $added ?? '_'}} %   </td>
                    </tr>
                    <tr>
                        <th width="200">@lang('orders.attributes.total')</th>
                        <td>{{ price($order->total + $order->shipping_cost) }}</td>
                    </tr>
                 
                 
                    
                    <tr>
                        <th width="200">@lang('orders.attributes.created_at')</th>
                        <td>{{ new \App\Support\Date($order->created_at) }}</td>
                    </tr>
                    <tr>
                    <th width="200"> @lang('admins.attributes.fulladd')</th>
                       
                       <td>{{ $order->address->cities[0]->name ?? '_'  }} /{{ $order->address->cities[1]->name ?? '_'  }}/ {{ $order->address->cities[2]->name ?? '_'  }}/ {{ $order->address->cities[3]->name ?? '_'  }} </td>
                   </tr>
                    </tr>
                    </tbody>
                </table>

                @slot('footer')
                    @include('dashboard.orders.partials.actions.edit')
                    @include('dashboard.orders.partials.actions.delete')
                    @include('dashboard.orders.partials.actions.restore')
                    @include('dashboard.orders.partials.actions.forceDelete')
                @endslot
            @endcomponent
        </div>
        <div class="col-md-8">
            <h4>{{ trans('orders.shipments') }}</h4>
            <div class="card card-secondary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                        @foreach($order->shopOrders as $shopOrder)
                            <li class="nav-item">
                                <a class="nav-link{{ $loop->first ? ' active' : '' }}"
                                   id="shop-order-{{ $shopOrder->id }}-tab"
                                   data-toggle="pill"
                                   href="#shop-order-{{ $shopOrder->id }}"
                                   role="tab"
                                   aria-controls="shop-order-{{ $shopOrder->id }}"
                                   aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                    {{ $shopOrder->shop->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-four-tabContent">
                        @foreach($order->shopOrders as $shopOrder)
                            <div class="tab-pane fade{{ $loop->first ? ' show active' : '' }}"
                                 id="shop-order-{{ $shopOrder->id }}"
                                 role="tabpanel"
                                 aria-labelledby="shop-order-{{ $shopOrder->id }}-tab">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="tw-bg-gray-300 p-4 rounded-lg">
                                            <ul class="list-unstyled mb-0">
                                                <li>
                                                    <strong>@lang('orders.attributes.shop_order_id'): </strong>
                                                    {{ $shopOrder->id }}
                                                </li>
                                                <li>
                                                    <strong>@lang('orders.attributes.status'): </strong>
                                                    @lang('orders.statuses.'. $shopOrder->status)
                                                </li>
                                                @if($shopOrder->delegate)
                                                    <li>
                                                        <strong>@lang('delegates.singular'): </strong>
                                                        @include('dashboard.accounts.delegates.partials.actions.link', ['delegate' => $shopOrder->delegate])
                                                    </li>
                                                @endif
                                                <li>
                                                    <strong>@lang('orders.attributes.sub_total'): </strong>
                                                    {{ price($shopOrder->sub_total) }}
                                                </li>
                                                <li>
                                                    <strong>@lang('orders.attributes.sub_total'): </strong>
                                                    {{ price($shopOrder->shipping_cost) }}
                                                </li>
                                             
                                                <li>
                                                    <strong>@lang('orders.attributes.total'): </strong>
                                                    {{ price($shopOrder->total) }}
                                                </li>
                                               
                                                <li>
                                                    <strong> @lang('orders.attributes.profit_system'): </strong>
                                                    {{ price($shopOrder->profit_system) }}
                                                </li>
                                                <li>
                                                    <strong> @lang('orders.attributes.profit_shop') : </strong>
                                                    {{ price($shopOrder->profit_shop) }}
                                                </li>
                                              
                                                
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        @can('markAsAssignedToDelegate', $shopOrder)
                                            <h5 class="mb-2">@lang('orders.actions.assign-delegate')</h5>
                                            <hr>
                                            {{ BsForm::post(route('dashboard.shop_orders.assign-delegate', $shopOrder)) }}
                                            <selectdelaget
                                                    name="delegate_id"
                                                    label="@lang('delegates.singular')"
                                                    remote-url="{{ route('api.selectdelegate.select', ['id' => $shopOrder->shop->owner->city->id]) }}"
                                            ></selectdelaget>
                                            {{ BsForm::submit()->label(trans('orders.actions.save')) }}

                                            {{ BsForm::close() }}
                                        @endcan
                                    </div>
                                </div>
                                <h5 class="my-2">{{ trans('products.plural') }}</h5>
                                <table class="table table-hover table-striped table-valign-middle mt-2">
                                    <thead>
                                    <tr>
                                        <th>@lang('products.singular')</th>
                                        <th>@lang('orders.attributes.quantity')</th>
                                        <th>@lang('orders.attributes.size')</th>
                                        <th>@lang('orders.attributes.color')</th>
                                        <th>@lang('orders.attributes.total')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($shopOrder->items as $item)
                                        <tr>
                                            <td>@include('dashboard.products.partials.actions.link', ['product' => $item->product])</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ data_get($item->size, 'size') ?: '---' }}</td>
                                            <td>{{ data_get($item->color, 'name') ?: '---' }}</td>
                                            <td>{{ price($item->total) }}</td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</x-layout>
