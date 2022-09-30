@component('dashboard::components.sidebarItem')
    @slot('can', ['ability' => 'manage', 'model' => \App\Models\Setting::class])
    @slot('url', '#')
    @slot('name', trans('settings.plural'))
    @slot('active', request()->routeIs('*settings*'))
    @slot('icon', 'fas fa-cogs')
    @slot('tree', [
        [
            'name' => trans('settings.tabs.main'),
            'url' => route('dashboard.settings.index', ['tab' => 'main']),
            'active' => request()->routeIs('*settings*') && request('tab') == 'main',
        ],
        [
            'name' => trans('settings.tabs.contacts'),
            'url' => route('dashboard.settings.index', ['tab' => 'contacts']),
            'active' => request()->routeIs('*settings*') && request('tab') == 'contacts',
        ],
        [
            'name' => trans('settings.tabs.about'),
            'url' => route('dashboard.settings.index', ['tab' => 'about']),
            'active' => request()->routeIs('*settings*') && request('tab') == 'about',
        ],
        [
            'name' => trans('settings.tabs.terms'),
            'url' => route('dashboard.settings.index', ['tab' => 'terms']),
            'active' => request()->routeIs('*settings*') && request('tab') == 'terms',
        ],
        [
            'name' => trans('settings.tabs.privacy'),
            'url' => route('dashboard.settings.index', ['tab' => 'privacy']),
            'active' => request()->routeIs('*settings*') && request('tab') == 'privacy',
        ],
        [
            'name' => trans('settings.tabs.mail'),
            'url' => route('dashboard.settings.index', ['tab' => 'mail']),
            'active' => request()->routeIs('*settings*') && request('tab') == 'mail',
        ],
        [
            'name' => trans('settings.tabs.pusher'),
            'url' => route('dashboard.settings.index', ['tab' => 'pusher']),
            'active' => request()->routeIs('*settings*') && request('tab') == 'pusher',
        ],
        [
            'name' => trans('settings.tabs.tax'),
            'url' => route('dashboard.settings.index', ['tab' => 'tax']),
            'active' => request()->routeIs('*settings*') && request('tab') == 'tax',
        ],
        [
            'name' => trans('settings.tabs.added'),
            'url' => route('dashboard.settings.index', ['tab' => 'added']),
            'active' => request()->routeIs('*settings*') && request('tab') == 'added',
        ],
        [
            'name' => trans('settings.tabs.shipping_cost'),
            'url' => route('dashboard.settings.index', ['tab' => 'shipping_cost']),
            'active' => request()->routeIs('*settings*') && request('tab') == 'shipping_cost',
        ],
        [
            'name' => trans('settings.tabs.commission'),
            'url' => route('dashboard.settings.index', ['tab' => 'commission']),
            'active' => request()->routeIs('*settings*') && request('tab') == 'commission',
        ],
        
        
        
        [
            'name' => trans('backup.download'),
            'url' => route('dashboard.backup.download'),
        ],
    ])
@endcomponent


