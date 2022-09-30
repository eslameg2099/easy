@if($product)
    @if(method_exists($product, 'trashed') && $product->trashed())
        <a href="{{ route('dashboard.products.trashed.show', $product) }}" class="text-decoration-none text-ellipsis">
            {{ $product->name }}
        </a>
    @else
        <a href="{{ route('dashboard.products.show', $product) }}" class="text-decoration-none text-ellipsis">
            {{ $product->name }}
        </a>
    @endif
@else
    ---
@endif