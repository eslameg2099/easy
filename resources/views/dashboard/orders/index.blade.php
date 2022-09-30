<?php /** @var \App\Models\Order[]|\Illuminate\Pagination\LengthAwarePaginator $orders */?>
<x-layout :title="trans('orders.plural')" :breadcrumbs="['dashboard.orders.index']">
    @include('dashboard.orders.partials.filter')

    @component('dashboard::components.table-box')
        @slot('title')
            @lang('orders.actions.list') ({{ $orders->total() }})
        @endslot

        <thead>
        <tr>
          <th colspan="100">
            <div class="d-flex">
                <x-check-all-delete
                        type="{{ \App\Models\Order::class }}"
                        :resource="trans('orders.plural')"></x-check-all-delete>

                <div class="ml-2 d-flex justify-content-between flex-grow-1">
                    @include('dashboard.orders.partials.actions.create')
                    @include('dashboard.orders.partials.actions.trashed')
                </div>
            </div>
          </th>
        </tr>
        <tr>
            <th style="width: 30px;" class="text-center">
              <x-check-all></x-check-all>
            </th>
            <th>@lang('orders.attributes.id')</th>
            <th>@lang('orders.attributes.user_id')</th>
            <th>@lang('orders.attributes.status')</th>
            <th>@lang('orders.attributes.shop_orders_count')</th>
            <th>@lang('orders.attributes.total')</th>
            <th>@lang('orders.attributes.created_at')</th>
            <th style="width: 160px">...</th>
        </tr>
        </thead>
        <tbody>
        @forelse($orders as $order)
            <tr>
                <td class="text-center">
                  <x-check-all-item :model="$order"></x-check-all-item>
                </td>
                <td>
                    <a href="{{ route('dashboard.orders.show', $order) }}"
                       class="text-decoration-none text-ellipsis">
                        #{{ $order->id }}
                    </a>
                </td>
                <td>{{ $order->user->name  ?? '_' }}</td>
                <td>{{ $order->getReadableStatus() }}</td>
                <td>{{ $order->shopOrders->count() }}</td>
                <td>{{ price($order->total) }}</td>
                <td>{{ new \App\Support\Date($order->created_at) }}</td>

                <td style="width: 160px">
                    @include('dashboard.orders.partials.actions.show')
                    @include('dashboard.orders.partials.actions.edit')
                    @include('dashboard.orders.partials.actions.delete')
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('orders.empty')</td>
            </tr>
        @endforelse
        </tbody>

        @if($orders->hasPages())
            @slot('footer')
                {{ $orders->links() }}
            @endslot
        @endif
    @endcomponent
</x-layout>
