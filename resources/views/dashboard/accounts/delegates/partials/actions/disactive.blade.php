@if(method_exists($delegate, 'trashed') && $delegate->trashed())
    @can('view', $delegate)
        <a href="{{ route('dashboard.delegates.disactive', $shopOwner) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa-thumbs-down"></i>
        </a>
    @endcan
@else
    @can('view', $delegate)
        <a href="{{ route('dashboard.delegates.disactive', $delegate) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa-thumbs-down"></i>
        </a>
    @endcan
@endif