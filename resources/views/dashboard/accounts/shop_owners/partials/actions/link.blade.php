@if($shopOwner)
    @if(method_exists($shopOwner, 'trashed') && $shopOwner->trashed())
        <a href="{{ route('dashboard.shop_owners.trashed.show', $shopOwner) }}" class="text-decoration-none text-ellipsis">
            {{ $shopOwner->name }}
        </a>
    @else
        <a href="{{ route('dashboard.shop_owners.show', $shopOwner) }}" class="text-decoration-none text-ellipsis">
            {{ $shopOwner->name }}
        </a>
    @endif
@else
    ---
@endif