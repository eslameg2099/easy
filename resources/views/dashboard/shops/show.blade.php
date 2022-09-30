<x-layout :title="$shop->name" :breadcrumbs="['dashboard.shops.show', $shop]">
    <div class="row">
        <div class="col-md-6">
            @component('dashboard::components.box')
                @slot('class', 'p-0')
                @slot('bodyClass', 'p-0')
                <table class="table table-striped table-middle">
                    <tbody>
                    <tr>
                        <th width="200">@lang('shops.attributes.name')</th>
                        <td>{{ $shop->name }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('shops.attributes.category_name')</th>
                        <td>{{ $shop->category->name }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('shops.attributes.description')</th>
                        <td>{{ $shop->description }}</td>
                    </tr>
            
                    <tr>
                        <th width="200">@lang('shops.attributes.user_id')</th>
                        <td>
                            @include('dashboard.accounts.shop_owners.partials.actions.link', ['shopOwner' => $shop->owner])
                        </td>
                    </tr>
                    <tr>
                        <th width="200">@lang('shops.attributes.free_shipping')</th>
                        <td>
                            @if($shop->free_shipping == '1')
  نعم
                            @else
لا
                            @endif
                           </td>

                    </tr>
                    @if($shop->getFirstMedia('logo'))
                        <tr>
                            <th width="200">@lang('shops.attributes.logo')</th>
                            <td>
                                <file-preview :media="{{ $shop->getMediaResource('logo') }}"></file-preview>
                            </td>
                        </tr>
                    @endif
                    @if($shop->getFirstMedia('banner'))
                        <tr>
                            <th width="200">@lang('shops.attributes.banner')</th>
                            <td>
                                <file-preview :media="{{ $shop->getMediaResource('banner') }}"></file-preview>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>

                @slot('footer')
                    @include('dashboard.shops.partials.actions.edit')
                    @include('dashboard.shops.partials.actions.delete')
                    @include('dashboard.shops.partials.actions.restore')
                    @include('dashboard.shops.partials.actions.forceDelete')
                @endslot
            @endcomponent
        </div>
        <div class="col-md-6">
            @component('dashboard::components.box')
                @slot('class', 'p-0')
                @slot('bodyClass', 'p-0')

                <div class="d-flex align-items-center justify-content-between p-4">
                    <p class="mb-0 lead text-center">
                        @lang('shops.balance'): <span class="badge badge-success">{{ price($balance) }}</span>
                    </p>
                    @if($balance)
                        <a class="btn btn-primary btn-sm" href="{{ route('dashboard.shops.collect', $shop) }}">
                            @lang('shops.collect')
                        </a>
                    @endif
                </div>

            @endcomponent
            @if($collected->count())
                @component('dashboard::components.box')
                    @slot('title', trans('shops.transactions'))
                    @slot('class', 'p-0')
                    @slot('bodyClass', 'p-0')

                    <ul class="list-group">
                        @foreach($collected as $collect)
                            <li class="list-group-item">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span>{{ price($collect->amount) }}</span>
                                    <small class="text-muted">{{ new \App\Support\Date($collect->date) }}</small>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                @endcomponent
            @endif
        </div>
    </div>
</x-layout>
