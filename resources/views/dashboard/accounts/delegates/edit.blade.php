<x-layout :title="$delegate->name" :breadcrumbs="['dashboard.delegates.edit', $delegate]">
    {{ BsForm::resource('delegates')->putModel($delegate, route('dashboard.delegates.update', $delegate), ['files' => true]) }}
    @component('dashboard::components.box')
        @slot('title', trans('delegates.actions.edit'))

        @include('dashboard.accounts.delegates.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('delegates.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>
