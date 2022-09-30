<x-layout :title="trans('delegates.plural')" :breadcrumbs="['dashboard.delegates.index']">
    @include('dashboard.accounts.delegates.partials.filter')

    @component('dashboard::components.table-box')

        @slot('title')
            @lang('delegates.actions.list') ({{ count_formatted($delegates->total()) }})
        @endslot

        <thead>
        <tr>
            <th colspan="100">
                <div class="d-flex">
                    <x-check-all-delete
                            type="{{ \App\Models\Delegate::class }}"
                            :resource="trans('delegates.plural')"></x-check-all-delete>

                    <div class="ml-2 d-flex justify-content-between flex-grow-1">
                        @include('dashboard.accounts.delegates.partials.actions.create')
                        @include('dashboard.accounts.delegates.partials.actions.trashed')
                    </div>
                </div>
            </th>
        </tr>
        <tr>
            <th>
                <x-check-all></x-check-all>
            </th>
            <th>@lang('delegates.attributes.name')</th>
            <th class="d-none d-md-table-cell">@lang('delegates.attributes.email')</th>
            <th>@lang('delegates.attributes.phone')</th>
            <th>@lang('delegates.attributes.created_at')</th>
            <th style="width: 160px">...</th>
        </tr>
        </thead>
        <tbody>
        @forelse($delegates as $delegate)
            <tr>
                <td>
                    <x-check-all-item :model="$delegate"></x-check-all-item>
                </td>
                <td>
                    <a href="{{ route('dashboard.delegates.show', $delegate) }}"
                       class="text-decoration-none text-ellipsis">
                            <span class="index-flag">
                            @include('dashboard.accounts.delegates.partials.flags.svg')
                            </span>
                        <img src="{{ $delegate->getAvatar() }}"
                             alt="Product 1"
                             class="img-circle img-size-32 mr-2">
                        {{ $delegate->name }}
                    </a>
                </td>

                <td class="d-none d-md-table-cell">
                    {{ $delegate->email }}
                </td>
                <td>
                    @include('dashboard.accounts.delegates.partials.flags.phone')
                </td>
                <td>{{ $delegate->created_at->format('Y-m-d') }}</td>

                <td style="width: 160px">
                    @include('dashboard.accounts.delegates.partials.actions.show')
                    @if($delegate->phone_verified_at != null )
                    @include('dashboard.accounts.delegates.partials.actions.disactive')
                    @elseif($delegate->phone_verified_at == null )
                    @include('dashboard.accounts.delegates.partials.actions.active')
                    @endif
                    @include('dashboard.accounts.delegates.partials.actions.edit')
                    @include('dashboard.accounts.delegates.partials.actions.delete')
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('delegates.empty')</td>
            </tr>
        @endforelse

        @if($delegates->hasPages())
            @slot('footer')
                {{ $delegates->links() }}
            @endslot
        @endif
    @endcomponent
</x-layout>
