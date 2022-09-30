@can('viewAnyTrash', \App\Models\ShopOwner::class)
    <a href="{{ route('dashboard.shop_owners.trashed', request()->only('type')) }}" class="btn btn-outline-danger btn-sm">
        <i class="fas fa fa-fw fa-trash"></i>
        @lang('shop_owners.trashed')
    </a>
@endcan
