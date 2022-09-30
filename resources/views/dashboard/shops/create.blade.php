<x-layout :title="trans('shops.actions.create')" :breadcrumbs="['dashboard.shops.create', $ShopOwner]">
    {{ BsForm::resource('shops')->post(route('dashboard.shops.store')) }}
    @component('dashboard::components.box')
        @slot('title', trans('shops.actions.create'))

        @include('dashboard.shops.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('shops.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>