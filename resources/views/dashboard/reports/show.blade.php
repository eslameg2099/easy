<x-layout :title="$report->name" :breadcrumbs="['dashboard.reports.show', $report]">
    <div class="row">
        <div class="col-md-12">
            @component('dashboard::components.box')
                @slot('class', 'p-0')
                @slot('bodyClass', 'p-0')

                <table class="table table-striped table-middle">
                    <tbody>
                    <tr>
                        <th width="200">@lang('reports.attributes.user_id')</th>
                        <td>@include('dashboard.accounts.customers.partials.actions.link', ['customer' => $report->user])</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('reports.attributes.shop_order_id')</th>
                        <td>#{{ $report->order->id }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('reports.attributes.message')</th>
                        <td>{{ $report->message }}</td>
                    </tr>
                    </tbody>
                </table>

                @slot('footer')
                    @include('dashboard.reports.partials.actions.delete')
                    @include('dashboard.reports.partials.actions.restore')
                    @include('dashboard.reports.partials.actions.forceDelete')
                @endslot
            @endcomponent
        </div>
    </div>
</x-layout>
