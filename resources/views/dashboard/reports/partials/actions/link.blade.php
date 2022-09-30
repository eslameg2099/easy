@if($report)
    @if(method_exists($report, 'trashed') && $report->trashed())
        <a href="{{ route('dashboard.reports.trashed.show', $report) }}" class="text-decoration-none text-ellipsis">
            {{ $report->name }}
        </a>
    @else
        <a href="{{ route('dashboard.reports.show', $report) }}" class="text-decoration-none text-ellipsis">
            {{ $report->name }}
        </a>
    @endif
@else
    ---
@endif