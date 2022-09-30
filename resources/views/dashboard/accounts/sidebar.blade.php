@if(Gate::allows('viewAny', \App\Models\User::class)
    || Gate::allows('viewAny', \App\Models\Supervisor::class)
    || Gate::allows('viewAny', \App\Models\Delegate::class)
    || Gate::allows('viewAny', \App\Models\ShopOwner::class)
    || Gate::allows('viewAny', \App\Models\Customer::class))
    @component('dashboard::components.sidebarItem')
        @slot('url', '#')
        @slot('name', trans('users.plural'))
        @slot('active', request()->routeIs('*admins*') || request()->routeIs('*customers*'))
        @slot('icon', 'fas fa-users')
        @slot('tree', [
            [
                'name' => trans('admins.plural'),
                'url' => route('dashboard.admins.index'),
                'can' => ['ability' => 'viewAny', 'model' => \App\Models\Admin::class],
                'active' => request()->routeIs('*admins*'),
            ],
            [
                'name' => trans('supervisors.plural'),
                'url' => route('dashboard.supervisors.index'),
                'can' => ['ability' => 'viewAny', 'model' => \App\Models\Supervisor::class],
                'active' => request()->routeIs('*supervisors*'),
            ],
            [
                'name' => trans('shop_owners.plural'),
                'url' => route('dashboard.shop_owners.index'),
                'can' => ['ability' => 'viewAny', 'model' => \App\Models\ShopOwner::class],
                'active' => request()->routeIs('*shop_owners*'),
            ],
            [
                'name' => trans('delegates.plural'),
                'url' => route('dashboard.delegates.index'),
                'can' => ['ability' => 'viewAny', 'model' => \App\Models\Delegate::class],
                'active' => request()->routeIs('*delegates*'),
            ],
            [
                'name' => trans('customers.plural'),
                'url' => route('dashboard.customers.index'),
                'can' => ['ability' => 'viewAny', 'model' => \App\Models\Customer::class],
                'active' => request()->routeIs('*customers*'),
            ],
        ])
    @endcomponent
@endif
