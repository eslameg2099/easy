<x-layout :title="trans('shops.plural')" :breadcrumbs="['dashboard.shops.index']">
    @include('dashboard.shops.partials.filter')

    @component('dashboard::components.table-box')
        @slot('title')
            @lang('shops.actions.list') ({{ $shops->total() }})
        @endslot

        <thead>
        <tr>
          <th colspan="100">
            <div class="d-flex">
                <x-check-all-delete
                        type="{{ \App\Models\Shop::class }}"
                        :resource="trans('shops.plural')"></x-check-all-delete>

                <div class="ml-2 d-flex justify-content-between flex-grow-1">
                    @include('dashboard.shops.partials.actions.trashed')
                </div>
            </div>
          </th>
        </tr>
        <tr>
            <th style="width: 30px;" class="text-center">
              <x-check-all></x-check-all>
            </th>
            <th>@lang('shops.attributes.name')</th>
            <th>@lang('shops.attributes.user_id')</th>
            <th>القسم</th>

            <th>@lang('shops.attributes.created_at')</th>
            <th style="width: 160px">...</th>
        </tr>
        </thead>
        <tbody>
        @forelse($shops as $shop)
            <tr>
                <td class="text-center">
                  <x-check-all-item :model="$shop"></x-check-all-item>
                </td>
                <td>
                    <a href="{{ route('dashboard.shops.show', $shop) }}"
                       class="text-decoration-none text-ellipsis">

                        <img src="{{ $shop->getFirstMediaUrl('logo') }}"
                             alt="Image"
                             class="img-circle img-size-32 mr-2" style="height: 32px;">
                        {{ $shop->name }}
                    </a>
                </td>
                <td>
                    @include('dashboard.accounts.shop_owners.partials.actions.link', ['shopOwner' => $shop->owner])
                </td>
                <td>{{ $shop->category->name }}</td>

                <td>{{ $shop->created_at }}</td>


                <td style="width: 160px">
                    @include('dashboard.shops.partials.actions.show')
                    @include('dashboard.shops.partials.actions.edit')
                    @include('dashboard.shops.partials.actions.delete')
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('shops.empty')</td>
            </tr>
        @endforelse

        @if($shops->hasPages())
            @slot('footer')
                {{ $shops->links() }}
            @endslot
        @endif
    @endcomponent
</x-layout>
