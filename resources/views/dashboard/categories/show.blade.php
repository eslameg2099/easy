<x-layout :title="$category->name" :breadcrumbs="['dashboard.categories.show', $category]">
    <div class="row">
        <div class="col-md-12">
            @component('dashboard::components.box')
                @slot('class', 'p-0')
                @slot('bodyClass', 'p-0')

                <table class="table table-striped table-middle">
                    <tbody>
                    <tr>
                        <th width="180">@lang('categories.attributes.name')</th>
                        <td>{{ $category->name }}</td>
                    </tr>
                    <tr>
                        <th width="180">@lang('categories.attributes.display_in_home')</th>
                        <td>
                            <x-boolean :is="$category->display_in_home"></x-boolean>
                        </td>
                    </tr>
                    @if($category->country)
                        <tr>
                            <th width="200">@lang('categories.attributes.country_id')</th>
                            <td>
                                @include('dashboard.countries.partials.actions.link', [
                                    'country' => $category->country,
                                ])
                            </td>
                        </tr>
                    @endif
                    @if($category->getFirstMedia())
                        <tr>
                            <th width="200">@lang('categories.attributes.image')</th>
                            <td>
                                <file-preview :media="{{ $category->getMediaResource() }}"></file-preview>
                            </td>
                        </tr>
                    @endif
                    @if($category->getFirstMedia('banner'))
                        <tr>
                            <th width="200">@lang('categories.attributes.banner')</th>
                            <td>
                                <file-preview :media="{{ $category->getMediaResource('banner') }}"></file-preview>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>

                @slot('footer')
                    @include('dashboard.categories.partials.actions.edit')
                    @include('dashboard.categories.partials.actions.delete')
                    @include('dashboard.categories.partials.actions.restore')
                    @include('dashboard.categories.partials.actions.forceDelete')
                @endslot
            @endcomponent
        </div>
        @if($category->getWithParents()->count() < Settings::get('max_category_levels', 3))
            @php(BsForm::resource('categories'))
            <div class="col-md-4">
                {{ BsForm::post(route('dashboard.categories.store', ['parent_id' => $category->id])) }}
                @component('dashboard::components.box')
                    @slot('title', trans('categories.actions.create-subcategory'))

                    @include('dashboard.categories.partials.form')

                    @slot('footer')
                        {{ BsForm::submit()->label(trans('categories.actions.save')) }}
                    @endslot
                @endcomponent
                {{ BsForm::close() }}
            </div>
            <div class="col-md-8">
                @component('dashboard::components.table-box')
                    @slot('title')
                        @lang('categories.children') ({{ $children->total() }})
                    @endslot

                    <thead>
                    <tr>
                        <th colspan="100">
                            <div class="d-flex">
                                <x-check-all-delete
                                        type="{{ \App\Models\Category::class }}"
                                        :resource="trans('categories.plural')"></x-check-all-delete>
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th style="width: 30px;" class="text-center">
                            <x-check-all></x-check-all>
                        </th>
                        <th>@lang('categories.attributes.name')</th>
                        @if($isLastLevel = $category->getWithParents()->count() < (Settings::get('max_category_levels', 3) - 1))
                            <th>@lang('categories.attributes.children_count')</th>
                        @endif
                        <th style="width: 160px">...</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($children as $subcategory)
                        <tr>
                            <td class="text-center">
                                <x-check-all-item :model="$subcategory"></x-check-all-item>
                            </td>
                            <td>
                                <a href="{{ route('dashboard.categories.show', $subcategory) }}"
                                   class="text-decoration-none text-ellipsis">
                                    @if($subcategory->getFirstMediaUrl())
                                        <img src="{{ $subcategory->getFirstMediaUrl() }}"
                                             alt="Image"
                                             class="img-circle img-size-32 mr-2" style="height: 32px;">
                                    @endif
                                    {{ $subcategory->name }}
                                </a>
                            </td>
                            @if($isLastLevel)
                                <td>
                                    <span class="badge badge-success">
                                        {{ count_formatted($subcategory->children_count) }}
                                    </span>
                                </td>
                            @endif

                            <td style="width: 160px">
                                @include('dashboard.categories.partials.actions.show', ['category' => $subcategory])
                                @include('dashboard.categories.partials.actions.edit', ['category' => $subcategory])
                                @include('dashboard.categories.partials.actions.delete', ['category' => $subcategory])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100" class="text-center">@lang('categories.empty')</td>
                        </tr>
                    @endforelse

                    @if($children->hasPages())
                        @slot('footer')
                            {{ $children->links() }}
                        @endslot
                    @endif
                @endcomponent
            </div>
        @endif
    </div>
</x-layout>
