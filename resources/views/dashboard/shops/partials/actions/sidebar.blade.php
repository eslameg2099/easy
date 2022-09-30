@component('dashboard::components.sidebarItem')
    @slot('can', ['ability' => 'viewAny', 'model' => \App\Models\Shop::class])
    @slot('url', route('dashboard.shops.index'))
    @slot('name', trans('shops.plural'))
    @slot('active', request()->routeIs('*shops*'))
    @slot('icon', 'fas fa-building')
    @slot('tree', [
        [
            'name' => trans('shops.actions.list'),
            'url' => route('dashboard.shops.index'),
            'can' => ['ability' => 'viewAny', 'model' => \App\Models\Shop::class],
            'active' => request()->routeIs('*shops.index')
            || request()->routeIs('*shops.show'),
        ],
       
    ])
@endcomponent
