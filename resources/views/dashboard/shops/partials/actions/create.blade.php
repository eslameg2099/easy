@can('create', \App\Models\Shop::class)
    <a href="{{ route('dashboard.shops.create', $shopOwner->id) }}" class="btn btn-outline-success btn-sm">
        
        <i class="fas fa fa-fw fa-plus"></i>
        
    </a>
@endcan
