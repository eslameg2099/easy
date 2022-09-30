<x-layout :title="trans('settings.tabs.commission')" :breadcrumbs="['dashboard.settings.index']">
    {{ BsForm::resource('settings')->patch(route('dashboard.settings.update')) }}
    @component('dashboard::components.box')

        {{ BsForm::number('commission_level_1')->value(Settings::get('commission_level_1'))->min(1)->step('any')  }}
        {{ BsForm::number('commission_level_2')->value(Settings::get('commission_level_2'))->min(1)->step('any') }}
        {{ BsForm::number('commission_level_3')->value(Settings::get('commission_level_3'))->min(1)->step('any') }}
        {{ BsForm::number('commission_level_4')->value(Settings::get('commission_level_4'))->min(1)->step('any') }}
      

        @slot('footer')
            {{ BsForm::submit()->label(trans('settings.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>