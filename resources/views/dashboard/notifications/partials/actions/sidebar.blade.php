@component('dashboard::components.sidebarItem')
    @slot('url', route('dashboard.notifications.index'))
    @slot('name', trans('notifications.plural'))
    @slot('active', request()->routeIs('*notifications*'))
    @slot('icon', 'fas fa-envelope')
@endcomponent
