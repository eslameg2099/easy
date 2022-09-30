@can('viewAnyTrash', \App\Models\Report::class)
    <a href="{{ route('dashboard.reports.trashed') }}" class="btn btn-outline-danger btn-sm">
        <i class="fas fa fa-fw fa-trash"></i>
        @lang('reports.trashed')
    </a>
@endcan
