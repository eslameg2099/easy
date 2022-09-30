@if(method_exists($product, 'trashed') && $product->trashed())
    @can('view', $product)
        <a href="{{ route('dashboard.products.trashed.show', $product) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@else
    @can('view', $product)
        <a href="{{ route('dashboard.products.show', $product) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@endif