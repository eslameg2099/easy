<x-layout :title="trans('products.actions.create')" :breadcrumbs="['dashboard.products.create']">
    {{ BsForm::resource('products')->post(route('dashboard.products.store')) }}
    @component('dashboard::components.box')
        @slot('title', trans('products.actions.create'))

        @include('dashboard.products.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('products.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>