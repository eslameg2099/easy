@can('viewAnyTrash', \App\Models\Shop::class)
    <a href="{{ route('dashboard.shops.trashed') }}" class="btn btn-outline-danger btn-sm">
        <i class="fas fa fa-fw fa-trash"></i>
        @lang('shops.trashed')
    </a>
@endcan
