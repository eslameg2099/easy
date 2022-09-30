<x-layout :title="$address->name" :breadcrumbs="['dashboard.addresses.edit', $address]">
    {{ BsForm::resource('addresses')->putModel($address, route('dashboard.addresses.update', $address)) }}
    @component('dashboard::components.box')
        @slot('title', trans('addresses.actions.edit'))

        @include('dashboard.addresses.partials.form2')

        @slot('footer')
            {{ BsForm::submit()->label(trans('addresses.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>