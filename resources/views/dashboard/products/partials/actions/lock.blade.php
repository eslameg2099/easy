@if(! $product->locked())
        <a href="{{ route('dashboard.products.lock', $product) }}"  class="btn btn-outline-danger btn-sm">
            @lang('products.actions.lock')
        </a>
@else
    <a href="{{ route('dashboard.products.lock', $product) }}"  class="btn btn-outline-primary btn-sm">
        @lang('products.actions.unlock')
    </a>
@endif