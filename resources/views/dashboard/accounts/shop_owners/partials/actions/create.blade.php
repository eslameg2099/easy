@can('create', \App\Models\ShopOwner::class)
    <a href="{{ route('dashboard.shop_owners.create', request()->only('type')) }}" class="btn btn-outline-success btn-sm">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('shop_owners.actions.create')
    </a>
@endcan
