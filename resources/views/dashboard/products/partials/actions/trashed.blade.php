@can('viewAnyTrash', \App\Models\Product::class)
    <a href="{{ route('dashboard.products.trashed') }}" class="btn btn-outline-danger btn-sm">
        <i class="fas fa fa-fw fa-trash"></i>
        @lang('products.trashed')
    </a>
@endcan
