<x-layout  :breadcrumbs="['dashboard.settings.index']">
{{ BsForm::resource('settings')->patch(route('dashboard.settings.update')) }}
    @component('dashboard::components.box')

        {{ BsForm::number('tax')
            ->attribute('class', 'form-control text')
            ->value(Settings::get('tax'))
            ->min(1)->step('any')
            ->label(trans('settings.tabs.tax')) }}

        @slot('footer')
            {{ BsForm::submit()->label(trans('settings.actions.save')) }}
        @endslot
    @endcomponent
</x-layout>