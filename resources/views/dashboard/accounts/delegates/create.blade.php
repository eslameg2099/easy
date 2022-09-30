<x-layout :title="trans('delegates.actions.create')" :breadcrumbs="['dashboard.delegates.create']">
    {{ BsForm::resource('delegates')->post(route('dashboard.delegates.store')) }}
    @component('dashboard::components.box')
        @slot('title', trans('delegates.actions.create'))

        @include('dashboard.accounts.delegates.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('delegates.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>