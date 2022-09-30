<x-layout :title="trans('delegates.trashed')" :breadcrumbs="['dashboard.delegates.trashed']">
    @include('dashboard.accounts.delegates.partials.filter')

    @component('dashboard::components.table-box')

        @slot('title')
            @lang('delegates.actions.list') ({{ count_formatted($delegates->total()) }})
        @endslot

        <thead>
        <tr>
            <th colspan="100">
                <x-check-all-force-delete
                        type="{{ \App\Models\Delegate::class }}"
                        :resource="trans('delegates.plural')"></x-check-all-force-delete>
                <x-check-all-restore
                        type="{{ \App\Models\Delegate::class }}"
                        :resource="trans('delegates.plural')"></x-check-all-restore>
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
                    <a href="{{ route('dashboard.delegates.trashed.show', $delegate) }}"
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
                    @include('dashboard.accounts.delegates.partials.actions.restore')
                    @include('dashboard.accounts.delegates.partials.actions.forceDelete')
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
