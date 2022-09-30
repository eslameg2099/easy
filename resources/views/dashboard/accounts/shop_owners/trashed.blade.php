<x-layout :title="trans('shop_owners.trashed')" :breadcrumbs="['dashboard.shop_owners.trashed']">
    @include('dashboard.accounts.shop_owners.partials.filter')

    @component('dashboard::components.table-box')

        @slot('title')
            @lang('shop_owners.actions.list') ({{ count_formatted($shopOwners->total()) }})
        @endslot

        <thead>
        <tr>
            <th colspan="100">
                <x-check-all-force-delete
                        type="{{ \App\Models\ShopOwner::class }}"
                        :resource="trans('shop_owners.plural')"></x-check-all-force-delete>
                <x-check-all-restore
                        type="{{ \App\Models\ShopOwner::class }}"
                        :resource="trans('shop_owners.plural')"></x-check-all-restore>
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
                    <a href="{{ route('dashboard.shop_owners.trashed.show', $shopOwner) }}"
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

                <td style="width: 160px">
                    @include('dashboard.accounts.shop_owners.partials.actions.show')
                    @include('dashboard.accounts.shop_owners.partials.actions.restore')
                    @include('dashboard.accounts.shop_owners.partials.actions.forceDelete')
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
