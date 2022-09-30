@component('dashboard::components.sidebarItem')
    @slot('can', ['ability' => 'viewAny', 'model' => \App\Models\Address::class])
    @slot('url', route('dashboard.addresses.index'))
    @slot('name', trans('addresses.plural'))
    @slot('active', request()->routeIs('*addresses*'))
    @slot('icon', 'fas fa-th')
    @slot('tree', [
        [
            'name' => trans('addresses.actions.list'),
            'url' => route('dashboard.addresses.index'),
            'can' => ['ability' => 'viewAny', 'model' => \App\Models\Address::class],
            'active' => request()->routeIs('*addresses.index')
            || request()->routeIs('*addresses.show'),
        ],
        [
            'name' => trans('addresses.actions.create'),
            'url' => route('dashboard.addresses.create'),
            'can' => ['ability' => 'create', 'model' => \App\Models\Address::class],
            'active' => request()->routeIs('*addresses.create'),
        ],
    ])
@endcomponent
