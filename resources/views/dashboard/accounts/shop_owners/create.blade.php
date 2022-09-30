<x-layout :title="trans('shop_owners.actions.create')" :breadcrumbs="['dashboard.shop_owners.create']">
    {{ BsForm::resource('shop_owners')->post(route('dashboard.shop_owners.store')) }}
    @component('dashboard::components.box')
        @slot('title', trans('shop_owners.actions.create'))

        @include('dashboard.accounts.shop_owners.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('shop_owners.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>