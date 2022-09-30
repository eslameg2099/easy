@if(method_exists($shop, 'trashed') && $shop->trashed())
    @can('view', $shop)
        <a href="{{ route('dashboard.shops.trashed.show', $shop) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@else
    @can('view', $shop)
        <a href="{{ route('dashboard.shops.show', $shop) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@endif