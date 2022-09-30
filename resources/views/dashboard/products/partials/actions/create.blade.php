@can('create', \App\Models\Product::class)
    <a href="{{ route('dashboard.products.create') }}" class="btn btn-outline-success btn-sm">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('products.actions.create')
    </a>
@endcan
