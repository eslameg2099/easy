@if($shop)
    @if(method_exists($shop, 'trashed') && $shop->trashed())
        <a href="{{ route('dashboard.shops.trashed.show', $shop) }}" class="text-decoration-none text-ellipsis">
            {{ $shop->name }}
        </a>
    @else
        <a href="{{ route('dashboard.shops.show', $shop) }}" class="text-decoration-none text-ellipsis">
            {{ $shop->name }}
        </a>
    @endif
@else
    ---
@endif