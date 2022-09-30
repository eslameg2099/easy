@component('dashboard::components.sidebarItem')
    @slot('can', ['ability' => 'viewAny', 'model' => \App\Models\Category::class])
    @slot('url', route('dashboard.categories.index'))
    @slot('name', trans('categories.plural'))
    @slot('active', request()->routeIs('*categories*'))
    @slot('icon', 'fas fa-th')
    @slot('tree', [
        [
            'name' => trans('categories.actions.list'),
            'url' => route('dashboard.categories.index'),
            'can' => ['ability' => 'viewAny', 'model' => \App\Models\Category::class],
            'active' => request()->routeIs('*categories.index')
            || request()->routeIs('*categories.show'),
        ],
        [
            'name' => trans('categories.actions.create'),
            'url' => route('dashboard.categories.create'),
            'can' => ['ability' => 'create', 'model' => \App\Models\Category::class],
            'active' => request()->routeIs('*categories.create'),
        ],
    ])
@endcomponent
