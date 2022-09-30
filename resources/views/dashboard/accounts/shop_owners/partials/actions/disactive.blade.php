@if(method_exists($shopOwner, 'trashed') && $shopOwner->trashed())
    @can('view', $shopOwner)
        <a href="{{ route('dashboard.shop_owners.disactive', $shopOwner) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa-thumbs-down"></i>
        </a>
    @endcan
@else
    @can('view', $shopOwner)
        <a href="{{ route('dashboard.shop_owners.disactive', $shopOwner) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa-thumbs-down"></i>
        </a>
    @endcan
@endif