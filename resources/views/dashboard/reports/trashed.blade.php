<x-layout :title="trans('reports.trashed')" :breadcrumbs="['dashboard.reports.trashed']">
    @include('dashboard.reports.partials.filter')

    @component('dashboard::components.table-box')
        @slot('title')
            @lang('reports.actions.list') ({{ count_formatted($reports->total()) }})
        @endslot

        <thead>
        <tr>
            <th colspan="100">
                <div class="d-flex">
                    <x-check-all-force-delete
                            type="{{ \App\Models\Report::class }}"
                            :resource="trans('reports.plural')"></x-check-all-force-delete>
                    <div class="ml-2">
                        <x-check-all-restore
                                type="{{ \App\Models\Report::class }}"
                                :resource="trans('reports.plural')"></x-check-all-restore>
                    </div>
                </div>
            </th>
        </tr>
        <tr>
            <th>
                <x-check-all></x-check-all>
            </th>
            <th>@lang('reports.attributes.user_id')</th>
            <th>@lang('reports.attributes.shop_order_id')</th>
            <th>@lang('reports.attributes.message')</th>
            <th style="width: 160px">...</th>
        </tr>
        </thead>
        <tbody>
        @forelse($reports as $report)
            <tr class="{{ $report->read() ? 'tw-bg-gray-300' : 'font-weight-bold tw-bg-gray-100' }}">
                <td>
                    <x-check-all-item :model="$report"></x-check-all-item>
                </td>
                <td>
                    <a href="{{ route('dashboard.reports.show', $report) }}"
                       class="text-decoration-none text-ellipsis">
                        {{ $report->user->name }}
                    </a>
                </td>
                <td>#{{ $report->order->order->id }}</td>
                <td>{{ Str::limit($report->message, 10) }}</td>

                <td style="width: 160px">
                    @include('dashboard.reports.partials.actions.show', ['reports' => $report])
                    @include('dashboard.reports.partials.actions.restore', ['reports' => $report])
                    @include('dashboard.reports.partials.actions.forceDelete', ['reports' => $report])
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('reports.empty')</td>
            </tr>
        @endforelse

        @if($reports->hasPages())
            @slot('footer')
                {{ $reports->links() }}
            @endslot
        @endif
    @endcomponent
</x-layout>
