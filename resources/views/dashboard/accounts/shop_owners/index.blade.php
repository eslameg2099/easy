<x-layout :title="trans('shop_owners.plural')" :breadcrumbs="['dashboard.shop_owners.index']">
    @include('dashboard.accounts.shop_owners.partials.filter')

    @component('dashboard::components.table-box')

        @slot('title')
            @lang('shop_owners.actions.list') ({{ count_formatted($shopOwners->total()) }})
        @endslot

        <thead>
        <tr>
            <th colspan="100">
                <div class="d-flex">
                    <x-check-all-delete
                            type="{{ \App\Models\ShopOwner::class }}"
                            :resource="trans('shop_owners.plural')"></x-check-all-delete>

                    <div class="ml-2 d-flex justify-content-between flex-grow-1">
                        @include('dashboard.accounts.shop_owners.partials.actions.create')
                        @include('dashboard.accounts.shop_owners.partials.actions.trashed')
                    </div>
                </div>
            </th>
        </tr>
        <tr>
            <th>
                <x-check-all></x-check-all>
            </th>
            <th>@lang('shop_owners.attributes.name')</th>
            <th class="d-none d-md-table-cell">@lang('shop_owners.attributes.email')</th>
            <th>@lang('shop_owners.attributes.phone')</th>
            <th>@lang('shop_owners.attributes.created_at')</th>
            <th style="width: 160px">...</th>
        </tr>
        </thead>
        <tbody>
        @forelse($shopOwners as $shopOwner)
            <tr>
                <td>
                    <x-check-all-item :model="$shopOwner"></x-check-all-item>
                </td>
                <td>
                    <a href="{{ route('dashboard.shop_owners.show', $shopOwner) }}"
                       class="text-decoration-none text-ellipsis">
                            <span class="index-flag">
                            @include('dashboard.accounts.shop_owners.partials.flags.svg')
                            </span>
                        <img src="{{ $shopOwner->getAvatar() }}"
                             alt="Product 1"
                             class="img-circle img-size-32 mr-2">
                        {{ $shopOwner->name }}
                    </a>
                </td>

                <td class="d-none d-md-table-cell">
                    {{ $shopOwner->email }}
                </td>
                <td>
                    @include('dashboard.accounts.shop_owners.partials.flags.phone')
                </td>
                <td>{{ $shopOwner->created_at->format('Y-m-d') }}</td>

                <td style="width: 240px">
                    @include('dashboard.accounts.shop_owners.partials.actions.show')
                    @if($shopOwner->phone_verified_at != null )
                    @include('dashboard.accounts.shop_owners.partials.actions.disactive')
                    @elseif($shopOwner->phone_verified_at == null )
                    @include('dashboard.accounts.shop_owners.partials.actions.active')
                    @endif
                    @include('dashboard.accounts.shop_owners.partials.actions.edit')
                    @include('dashboard.accounts.shop_owners.partials.actions.delete')
                    @if($shopOwner->shop()->count() == 0)
                    @include('dashboard.shops.partials.actions.create')
                    @else

                    @endif

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('shop_owners.empty')</td>
            </tr>
        @endforelse

        @if($shopOwners->hasPages())
            @slot('footer')
                {{ $shopOwners->links() }}
            @endslot
        @endif
    @endcomponent
</x-layout>
