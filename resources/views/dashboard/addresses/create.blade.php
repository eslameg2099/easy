<x-layout :title="trans('addresses.actions.create')" :breadcrumbs="['dashboard.addresses.create', $Customer]">
    {{ BsForm::resource('addresses')->post(route('dashboard.addresses.store')) }}
    @component('dashboard::components.box')
        @slot('title', trans('addresses.actions.create'))

        @include('dashboard.addresses.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('addresses.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>