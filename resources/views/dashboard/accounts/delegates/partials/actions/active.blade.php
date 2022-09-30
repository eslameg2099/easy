@if(method_exists($delegate, 'trashed') && $delegate->trashed())
    @can('view', $delegate)
        <a href="{{ route('dashboard.delegates.active', $delegate) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa-thumbs-up"></i>
        </a>
    @endcan
@else
    @can('view', $delegate)
        <a href="{{ route('dashboard.delegates.active', $delegate) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa-thumbs-up"></i>
        </a>
    @endcan
@endif