@component('dashboard::components.sidebarItem')
    @slot('url', route('dashboard.home'))
    @slot('name', trans('dashboard.home'))
    @slot('icon', 'fas fa-tachometer-alt')
    @slot('active', request()->routeIs('dashboard.home'))
@endcomponent

@include('dashboard.cities.partials.actions.sidebar')
@include('dashboard.accounts.sidebar')
@include('dashboard.shops.partials.actions.sidebar')
@include('dashboard.categories.partials.actions.sidebar')
@include('dashboard.products.partials.actions.sidebar')
@include('dashboard.orders.partials.actions.sidebar')
{{--@include('dashboard.addresses.partials.actions.sidebar')--}}
@include('dashboard.reports.partials.actions.sidebar')
@include('dashboard.coupons.partials.actions.sidebar')
{{-- The sidebar of generated crud will set here: Don't remove this line --}}
@include('dashboard.feedback.partials.actions.sidebar')
@include('dashboard.notifications.partials.actions.sidebar')

@include('dashboard.settings.sidebar')
