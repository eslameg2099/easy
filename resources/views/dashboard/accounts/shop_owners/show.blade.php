<x-layout :title="$shopOwner->name" :breadcrumbs="['dashboard.shop_owners.show', $shopOwner]">
    @component('dashboard::components.box')
        @slot('bodyClass', 'p-0')

        <table class="table table-striped table-middle">
            <tbody>
            <tr>
                <th width="200">@lang('shop_owners.attributes.name')</th>
                <td>{{ $shopOwner->name }}</td>
            </tr>
            <tr>
                <th width="200">@lang('shop_owners.attributes.email')</th>
                <td>{{ $shopOwner->email }}</td>
            </tr>
            <tr>
                <th width="200">@lang('shop_owners.attributes.phone')</th>
                <td>
                    @include('dashboard.accounts.shop_owners.partials.flags.phone')
                </td>
            </tr>
            <tr>
                <th width="200">@lang('shop_owners.attributes.tax')</th>
                <td>{{ $shopOwner->tax }}</td>

            </tr>
            <tr>
                    <th width="200">@lang('admins.attributes.fulladd') </th>
                       
                        <td>{{ $shopOwner->cities[0]->name ?? '_'  }} /{{ $shopOwner->cities[1]->name ?? '_'  }}/ {{ $shopOwner->cities[2]->name ?? '_'  }}/ {{ $shopOwner->cities[3]->name ?? '_'  }} </td>
                    </tr>
            @if($city = $shopOwner->city)
                <tr>
                    <th width="200">@lang('cities.select')</th>
                    <td>
                        @include('dashboard.cities.partials.actions.link', compact('city'))
                    </td>
                </tr>
            @endif
            <tr>
                <th width="200">@lang('shop_owners.attributes.avatar')</th>
                <td>
                    @if($shopOwner->getFirstMedia('avatars'))
                        <file-preview :media="{{ $shopOwner->getMediaResource('avatars') }}"></file-preview>
                    @else
                        <img src="{{ $shopOwner->getAvatar() }}"
                             class="img img-size-64"
                             alt="{{ $shopOwner->name }}">
                    @endif
                </td>
            </tr>
            </tbody>
        </table>

        @slot('footer')
            @include('dashboard.accounts.shop_owners.partials.actions.edit')
            @include('dashboard.accounts.shop_owners.partials.actions.delete')
            @include('dashboard.accounts.shop_owners.partials.actions.restore')
            @include('dashboard.accounts.shop_owners.partials.actions.forceDelete')
        @endslot
    @endcomponent
</x-layout>
