<x-layout :title="$shop->name" :breadcrumbs="['dashboard.shops.edit', $shop]">
    {{ BsForm::resource('shops')->putModel($shop, route('dashboard.shops.update', $shop)) }}
    @component('dashboard::components.box')
        @slot('title', trans('shops.actions.edit'))

        @include('dashboard.shops.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('shops.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>