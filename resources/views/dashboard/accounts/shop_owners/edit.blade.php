<x-layout :title="$shopOwner->name" :breadcrumbs="['dashboard.shop_owners.edit', $shopOwner]">
    {{ BsForm::resource('shop_owners')->putModel($shopOwner, route('dashboard.shop_owners.update', $shopOwner), ['files' => true]) }}
    @component('dashboard::components.box')
        @slot('title', trans('shop_owners.actions.edit'))

        @include('dashboard.accounts.shop_owners.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('shop_owners.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>
