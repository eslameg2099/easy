<x-layout  :breadcrumbs="['dashboard.settings.index']">
{{ BsForm::resource('settings')->patch(route('dashboard.settings.update')) }}
    @component('dashboard::components.box')

        {{ BsForm::number('shipping_cost')
            ->attribute('class', 'form-control text')
            ->value(Settings::get('shipping_cost'))
            ->label(trans('settings.tabs.shipping_cost')) }}

        @slot('footer')
            {{ BsForm::submit()->label(trans('settings.actions.save')) }}
        @endslot
    @endcomponent
</x-layout>