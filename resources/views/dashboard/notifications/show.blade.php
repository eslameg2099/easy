<x-layout :title="trans('notifications.plural-certain')" :breadcrumbs="['dashboard.notifications.certain']">
    {{ BsForm::resource('notifications')->post(route('dashboard.notifications.store')) }}
    @component('dashboard::components.box')
        @slot('title', trans('notifications.actions.create'))

        @include('dashboard.notifications.partials.form_certain')

        @slot('footer')
            {{ BsForm::submit()->label(trans('notifications.actions.save')) }}
            
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>