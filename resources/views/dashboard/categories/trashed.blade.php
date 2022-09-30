<x-layout :title="trans('categories.trashed')" :breadcrumbs="['dashboard.categories.trashed']">
    @include('dashboard.categories.partials.filter')

    @component('dashboard::components.table-box')
        @slot('title')
            @lang('categories.actions.list') ({{ $categories->total() }})
        @endslot

        <thead>
        <tr>
          <th colspan="100">
              <x-check-all-force-delete
                      type="{{ \App\Models\Category::class }}"
                      :resource="trans('categories.plural')"></x-check-all-force-delete>
              <x-check-all-restore
                      type="{{ \App\Models\Category::class }}"
                      :resource="trans('categories.plural')"></x-check-all-restore>
          </th>
        </tr>
        <tr>
            <th style="width: 30px;" class="text-center">
              <x-check-all></x-check-all>
            </th>
            <th>@lang('categories.attributes.name')</th>
            <th>@lang('categories.attributes.children_count')</th>
            <th>@lang('categories.attributes.created_at')</th>
            <th style="width: 160px">...</th>
        </tr>
        </thead>
        <tbody>
        @forelse($categories as $category)
            <tr>
                <td class="text-center">
                  <x-check-all-item :model="$category"></x-check-all-item>
                </td>
                <td>
                    <a href="{{ route('dashboard.categories.trashed.show', $category) }}"
                       class="text-decoration-none text-ellipsis">

                        @if($category->getFirstMediaUrl())
                            <img src="{{ $category->getFirstMediaUrl() }}"
                                 alt="Image"
                                 class="img-circle img-size-32 mr-2" style="height: 32px;">
                        @endif
                        {{ $category->name }}
                    </a>
                </td>
                <td>
                    <span class="badge badge-success">
                        {{ count_formatted($category->children_count) }}
                    </span>
                </td>
                <td>{{ $category->created_at }}</td>

                <td style="width: 160px">
                    @include('dashboard.categories.partials.actions.show')
                    @include('dashboard.categories.partials.actions.restore')
                    @include('dashboard.categories.partials.actions.forceDelete')
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('categories.empty')</td>
            </tr>
        @endforelse

        @if($categories->hasPages())
            @slot('footer')
                {{ $categories->links() }}
            @endslot
        @endif
    @endcomponent
</x-layout>
