@if(method_exists($shopOwner, 'trashed') && $shopOwner->trashed())
    @can('view', $shopOwner)
        <a href="{{ route('dashboard.shop_owners.trashed.show', $shopOwner) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@else
    @can('view', $shopOwner)
        <a href="{{ route('dashboard.shop_owners.show', $shopOwner) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@endif