<x-layout :title="trans('products.trashed')" :breadcrumbs="['dashboard.products.trashed']">
    @include('dashboard.products.partials.filter')

    @component('dashboard::components.table-box')
        @slot('title')
            @lang('products.actions.list') ({{ $products->total() }})
        @endslot

        <thead>
        <tr>
          <th colspan="100">
            <x-check-all-force-delete
                    type="{{ \App\Models\Product::class }}"
                    :resource="trans('products.plural')"></x-check-all-force-delete>
            <x-check-all-restore
                    type="{{ \App\Models\Product::class }}"
                    :resource="trans('products.plural')"></x-check-all-restore>
          </th>
        </tr>
        <tr>
            <th style="width: 30px;" class="text-center">
              <x-check-all></x-check-all>
            </th>
            <th>@lang('products.attributes.name')</th>
            <th style="width: 160px">...</th>
        </tr>
        </thead>
        <tbody>
        @forelse($products as $product)
            <tr>
                <td class="text-center">
                  <x-check-all-item :model="$product"></x-check-all-item>
                </td>
                <td>
                    <a href="{{ route('dashboard.products.trashed.show', $product) }}"
                       class="text-decoration-none text-ellipsis">

                        <img src="{{ $product->getFirstMediaUrl() }}"
                             alt="Image"
                             class="img-circle img-size-32 mr-2" style="height: 32px;">
                        {{ $product->name }}
                    </a>
                </td>

                <td style="width: 160px">
                    @include('dashboard.products.partials.actions.show')
                    @include('dashboard.products.partials.actions.restore')
                    @include('dashboard.products.partials.actions.forceDelete')
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('products.empty')</td>
            </tr>
        @endforelse

        @if($products->hasPages())
            @slot('footer')
                {{ $products->links() }}
            @endslot
        @endif
    @endcomponent
</x-layout>
