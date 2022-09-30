<x-layout :title="trans('settings.tabs.main')" :breadcrumbs="['dashboard.settings.index']">
    {{ BsForm::resource('settings')->patch(route('dashboard.settings.update')) }}
    @component('dashboard::components.box')

        @bsMultilangualFormTabs

        {{ BsForm::text('name')->value(Settings::locale($locale->code)->get('name')) }}

        {{ BsForm::text('copyright')->value(Settings::locale($locale->code)->get('copyright')) }}

        @endBsMultilangualFormTabs

        {{ BsForm::number('max_category_levels')->min(1)->value(Settings::get('max_category_levels')) }}

{{--        @if(is_array(trans('settings.dashboard_templates')) && ! empty(trans('settings.dashboard_templates')))--}}
{{--            {{ BsForm::select('dashboard_template')--}}
{{--                    ->options(trans('settings.dashboard_templates'))--}}
{{--                    ->value(Settings::get('dashboard_template', config('layouts.dashboard'))) }}--}}
{{--        @endif--}}

{{--        @if(is_array(trans('settings.frontend_templates')) && ! empty(trans('settings.frontend_templates')))--}}
{{--            {{ BsForm::select('frontend_template')--}}
{{--                    ->options(trans('settings.frontend_templates'))--}}
{{--                    ->value(Settings::get('frontend_template', config('layouts.frontend'))) }}--}}
{{--        @endif--}}

        {{ BsForm::price('shipping_cost')->value(Settings::get('shipping_cost')) }}

        {{ BsForm::checkbox('delete_forever')->checked(Settings::get('delete_forever'))->withDefault()->value(1) }}

        <div class="row">
            <div class="col-md-6">
                {{ BsForm::image('logo')->collection('logo')->files(
         optional(Settings::instance('logo'))->getMediaResource('logo')
 ) }}
            </div>
            <div class="col-md-6">
                {{ BsForm::image('favicon')->collection('favicon')->files(
           optional(Settings::instance('favicon'))->getMediaResource('favicon')
   ) }}
            </div>
            <div class="col-md-12">
                {{ BsForm::image('home_slider')->unlimited()->collection('home_slider')->files(
           optional(Settings::instance('home_slider'))->getMediaResource('home_slider')
   ) }}
            </div>
        </div>

        @slot('footer')
            {{ BsForm::submit()->label(trans('settings.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>