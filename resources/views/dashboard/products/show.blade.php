<x-layout :title="$product->name" :breadcrumbs="['dashboard.products.show', $product]">
    {{--    <div class="row">--}}
    {{--        <div class="col-md-6">--}}
    {{--            @component('dashboard::components.box')--}}
    {{--                @slot('class', 'p-0')--}}
    {{--                @slot('bodyClass', 'p-0')--}}

    {{--                <table class="table table-striped table-middle">--}}
    {{--                    <tbody>--}}
    {{--                    <tr>--}}
    {{--                        <th width="200">@lang('products.attributes.name')</th>--}}
    {{--                        <td>{{ $product->name }}</td>--}}
    {{--                    </tr>--}}
    {{--                    <tr>--}}
    {{--                        <th width="200">@lang('products.attributes.description')</th>--}}
    {{--                        <td>{!! $product->description !!}</td>--}}
    {{--                    </tr>--}}
    {{--                    <tr>--}}
    {{--                        <th width="200">@lang('products.attributes.shop_id')</th>--}}
    {{--                        <td>--}}
    {{--                            @include('dashboard.shops.partials.actions.link', ['shop' => $product->shop])--}}
    {{--                        </td>--}}
    {{--                    </tr>--}}
    {{--                    <tr>--}}
    {{--                        <th width="200">@lang('products.attributes.shop_id')</th>--}}
    {{--                        <td>--}}
    {{--                            @include('dashboard.shops.partials.actions.link', ['shop' => $product->shop])--}}
    {{--                        </td>--}}
    {{--                    </tr>--}}
    {{--                    <tr>--}}
    {{--                        <th width="200">@lang('products.attributes.category_id')</th>--}}
    {{--                        <td>--}}
    {{--                            @include('dashboard.categories.partials.actions.link', ['category' => $product->category])--}}
    {{--                        </td>--}}
    {{--                    </tr>--}}
    {{--                    <tr>--}}
    {{--                        <th width="200">@lang('products.attributes.price')</th>--}}
    {{--                        <td>--}}
    {{--                            @include('dashboard.products.partials.price')--}}
    {{--                        </td>--}}
    {{--                    </tr>--}}
    {{--                    @if($product->getFirstMedia())--}}
    {{--                        <tr>--}}
    {{--                            <th width="200">@lang('products.attributes.images')</th>--}}
    {{--                            <td>--}}
    {{--                                <file-preview :media="{{ $product->getMediaResource() }}"></file-preview>--}}
    {{--                            </td>--}}
    {{--                        </tr>--}}
    {{--                    @endif--}}
    {{--                    </tbody>--}}
    {{--                </table>--}}

    {{--                @slot('footer')--}}
    {{--                        @include('dashboard.products.partials.actions.edit')--}}
    {{--                        @include('dashboard.products.partials.actions.delete')--}}
    {{--                        @include('dashboard.products.partials.actions.restore')--}}
    {{--                        @include('dashboard.products.partials.actions.forceDelete')--}}
    {{--                @endslot--}}
    {{--            @endcomponent--}}
    {{--        </div>--}}
    {{--    </div>--}}
    <div class="card card-solid">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3 class="d-inline-block d-sm-none">{{ $product->name }}</h3>
                    <div class="col-12">
                        <img src="{{ $product->getFirstMediaUrl() }}" class="product-image" alt="Product Image">
                    </div>
                    <div class="col-12 product-image-thumbs">
                        @foreach($product->getMedia() as $media)
                            <div class="product-image-thumb {{ $loop->first ? 'active' : '' }}"><img
                                        src="{{ $media->getUrl() }}" alt="Product Image">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <h3 class="my-3">{{ $product->name }}</h3>
                    <ul>
                        <li>
                            @lang('products.attributes.shop_id'):
                            @include('dashboard.shops.partials.actions.link', ['shop' => $product->shop])
                        </li>
                        <li>
                            @lang('products.attributes.category_id'):
                            @include('dashboard.categories.partials.actions.link', ['category' => $product->category])
                        </li>
                    </ul>
                    {!! $product->description !!}

                    <hr>
                    @if(is_array($product->colors) && count($product->colors))
                        <h4>@lang('products.attributes.colors')</h4>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            @foreach($product->colors as $color)
                                <label class="btn btn-default text-center">
                                    {{ $color['name'] }}
                                    <br>
                                    <i class="fas fa-circle fa-2x" style="color:{{ $color['hex'] }};"></i>
                                </label>
                            @endforeach
                        </div>
                    @endif

                    @if(is_array($product->sizes) && count($product->sizes))
                        <h4 class="mt-3">@lang('products.attributes.sizes')</h4>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            @foreach($product->sizes as $size)
                                <label class="btn btn-default text-center">
                                    {{ $size['size'] }}
                                </label>
                            @endforeach
                        </div>
                    @endif

                    <div class="tw-bg-gray-700 tw-text-gray-100 py-2 px-3 mt-4">
                        <h2 class="mb-0">
                            @if($product->has_discount)
                                <bdi>
                                    <span class="text-muted">
                                        <s class="p-2">{{ price($product->price) }}</s>
                                    </span>
                                </bdi>
                                <bdi>
                                    <span class="p-2">{{ price($product->offer_price) }}</span>
                                </bdi>
                            @else
                                <bdi>
                                    <span class="p-2">{{ price($product->price) }}</span>
                                </bdi>
                            @endif
                        </h2>
                    </div>

                </div>
            </div>

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            @include('dashboard.products.partials.actions.lock')
            @include('dashboard.products.partials.actions.edit')
            @include('dashboard.products.partials.actions.delete')
            @include('dashboard.products.partials.actions.restore')
            @include('dashboard.products.partials.actions.forceDelete')
        </div>
    </div>
    <!-- /.card -->
    @push('styles')
        <style>
            .product-image {
                height: 500px;
                object-fit: contain;
            }
        </style>
    @endpush
    @push('scripts')
        <script>
          $(document).ready(function () {
            $('.product-image-thumb').on('click', function (e) {
              e.preventDefault();
              var $image_element = $(this).find('img')
              $('.product-image').prop('src', $image_element.attr('src'))
              $('.product-image-thumb.active').removeClass('active')
              $(this).addClass('active')
            })
          })
        </script>
    @endpush
</x-layout>
