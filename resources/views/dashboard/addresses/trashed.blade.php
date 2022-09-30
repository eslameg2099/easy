<x-layout :title="trans('addresses.trashed')" :breadcrumbs="['dashboard.addresses.trashed']">
    @include('dashboard.addresses.partials.filter')

    @component('dashboard::components.table-box')
        @slot('title')
            @lang('addresses.actions.list') ({{ $addresses->total() }})
        @endslot

        <thead>
        <tr>
          <th colspan="100">
            <x-check-all-force-delete
                    type="{{ \App\Models\Address::class }}"
                    :resource="trans('addresses.plural')"></x-check-all-force-delete>
            <x-check-all-restore
                    type="{{ \App\Models\Address::class }}"
                    :resource="trans('addresses.plural')"></x-check-all-restore>
          </th>
        </tr>
        <tr>
            <th style="width: 30px;" class="text-center">
              <x-check-all></x-check-all>
            </th>
            <th>@lang('addresses.attributes.name')</th>
            <th style="width: 160px">...</th>
        </tr>
        </thead>
        <tbody>
        @forelse($addresses as $address)
            <tr>
                <td class="text-center">
                  <x-check-all-item :model="$address"></x-check-all-item>
                </td>
                <td>
                    <a href="{{ route('dashboard.addresses.trashed.show', $address) }}"
                       class="text-decoration-none text-ellipsis">
                        {{ $address->name }}
                    </a>
                </td>

                <td style="width: 160px">
                    @include('dashboard.addresses.partials.actions.show')
                    @include('dashboard.addresses.partials.actions.restore')
                    @include('dashboard.addresses.partials.actions.forceDelete')
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('addresses.empty')</td>
            </tr>
        @endforelse

        @if($addresses->hasPages())
            @slot('footer')
                {{ $addresses->links() }}
            @endslot
        @endif
    @endcomponent
</x-layout>
