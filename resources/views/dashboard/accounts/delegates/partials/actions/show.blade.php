@if(method_exists($delegate, 'trashed') && $delegate->trashed())
    @can('view', $delegate)
        <a href="{{ route('dashboard.delegates.trashed.show', $delegate) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@else
    @can('view', $delegate)
        <a href="{{ route('dashboard.delegates.show', $delegate) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@endif