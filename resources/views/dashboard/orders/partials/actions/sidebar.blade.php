@component('dashboard::components.sidebarItem')
    @slot('can', ['ability' => 'viewAny', 'model' => \App\Models\Order::class])
    @slot('url', route('dashboard.orders.index'))
    @slot('name', trans('orders.plural'))
    @slot('active', request()->routeIs('*orders*'))

  
    @slot('tree', [
        [
            'name' => trans('orders.actions.list'),
            'url' => route('dashboard.orders.index'),
            'can' => ['ability' => 'viewAny', 'model' => \App\Models\Order::class],

            'active' => request()->routeIs('*orders.index') && ! request('status')
            || request()->routeIs('*orders.show'),

        ],
        ...collect(trans('orders.filters'))->map(function ($status, $code) {
            return [
                'name' => $status,
                'url' => route('dashboard.orders.index', ['status' => $code]),
                'can' => ['ability' => 'viewAny', 'model' => \App\Models\Order::class],
                'active' => request()->routeIs('*orders.index') && request('status') == $code,
                'badge'=> \App\Models\Order::wherehas('shopOrders')->where('status', $code)->count() ?: 0,
            
                
            ];
        })->toArray()
    ])
@endcomponent
