<x-layout  :breadcrumbs="['dashboard.settings.index']">
{{ BsForm::resource('settings')->patch(route('dashboard.settings.update')) }}
    @component('dashboard::components.box')

        {{ BsForm::number('added')
            ->attribute('class', 'form-control text')
            ->value(Settings::get('added'))
            ->min(0)->step('any')
            ->label(trans('settings.tabs.added')) }}

        @slot('footer')
            {{ BsForm::submit()->label(trans('settings.actions.save')) }}
        @endslot
    @endcomponent
</x-layout>

