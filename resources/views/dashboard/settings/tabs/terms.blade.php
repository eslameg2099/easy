<x-layout :title="trans('settings.tabs.terms')" :breadcrumbs="['dashboard.settings.index']">
    {{ BsForm::resource('settings')->patch(route('dashboard.settings.update')) }}
    @component('dashboard::components.box')
        @bsMultilangualFormTabs
        {{ BsForm::textarea('shop_terms')
            ->attribute('class', 'form-control textarea')
            ->value(Settings::locale($locale->code)->get('shop_terms')) }}
        {{ BsForm::textarea('delegate_terms')
            ->attribute('class', 'form-control textarea')
            ->value(Settings::locale($locale->code)->get('delegate_terms')) }}
        {{ BsForm::textarea('customer_terms')
            ->attribute('class', 'form-control textarea')
            ->value(Settings::locale($locale->code)->get('customer_terms')) }}
        @endBsMultilangualFormTabs

        @slot('footer')
            {{ BsForm::submit()->label(trans('settings.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>