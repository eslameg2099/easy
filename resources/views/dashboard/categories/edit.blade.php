<x-layout :title="$category->name" :breadcrumbs="['dashboard.categories.edit', $category]">
    {{ BsForm::resource('categories')->putModel($category, route('dashboard.categories.update', $category)) }}
    @component('dashboard::components.box')
        @slot('title', trans('categories.actions.edit'))

        @include('dashboard.categories.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('categories.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>