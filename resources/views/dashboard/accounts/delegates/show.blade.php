<x-layout :title="$delegate->name" :breadcrumbs="['dashboard.delegates.show', $delegate]">
    <div class="row">
        <div class="col-md-6">
            @component('dashboard::components.box')
                @slot('bodyClass', 'p-0')

                <table class="table table-striped table-middle">
                    <tbody>
                    <tr>
                        <th width="200">@lang('delegates.attributes.name')</th>
                        <td>{{ $delegate->name }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('delegates.attributes.email')</th>
                        <td>{{ $delegate->email }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('delegates.attributes.phone')</th>
                        <td>
                            @include('dashboard.accounts.delegates.partials.flags.phone')
                        </td>
                    </tr>
                    <th width="200">@lang('admins.attributes.fulladd')  </th>
                       
                        <td>{{ $delegate->cities[0]->name ?? '_'  }} /{{ $delegate->cities[1]->name ?? '_'  }}/ {{ $delegate->cities[2]->name ?? '_'  }}/ {{ $delegate->cities[3]->name ?? '_'  }} </td>
                    </tr>
                    @if($city = $delegate->city)
                        <tr>
                            <th width="200">@lang('cities.select')</th>
                            <td>
                                @include('dashboard.cities.partials.actions.link', compact('city'))
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th width="200">@lang('delegates.attributes.national_id')</th>
                        <td>{{ $delegate->national_id }}</td>
                    </tr>
                    @if($delegate->getFirstMedia('national_front_image'))
                        <tr>
                            <th width="200">@lang('delegates.attributes.national_front_image')</th>
                            <td>
                                <file-preview
                                        :media="{{ $delegate->getMediaResource('national_front_image') }}"></file-preview>
                            </td>
                        </tr>
                    @endif
                    @if($delegate->getFirstMedia('national_back_image'))
                        <tr>
                            <th width="200">@lang('delegates.attributes.national_back_image')</th>
                            <td>
                                <file-preview
                                        :media="{{ $delegate->getMediaResource('national_back_image') }}"></file-preview>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th width="200">@lang('delegates.attributes.vehicle_type')</th>
                        <td>{{ $delegate->vehicle_type }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('delegates.attributes.vehicle_model')</th>
                        <td>{{ $delegate->vehicle_model }}</td>
                    </tr>
                    @if($delegate->getFirstMedia('vehicle_image'))
                        <tr>
                            <th width="200">@lang('delegates.attributes.vehicle_image')</th>
                            <td>
                                <file-preview
                                        :media="{{ $delegate->getMediaResource('vehicle_image') }}"></file-preview>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th width="200">@lang('delegates.attributes.vehicle_number')</th>
                        <td>{{ $delegate->vehicle_number }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('delegates.attributes.is_available')</th>
                        <td>
                            <x-boolean :is="$delegate->is_available"></x-boolean>
                        </td>
                    </tr>
                    <tr>
                        <th width="200">@lang('delegates.attributes.is_approved')</th>
                        <td>
                            <x-boolean :is="$delegate->is_approved"></x-boolean>
                        </td>
                    </tr>
                    <tr>
                        <th width="200">@lang('delegates.attributes.avatar')</th>
                        <td>
                            @if($delegate->getFirstMedia('avatars'))
                                <file-preview :media="{{ $delegate->getMediaResource('avatars') }}"></file-preview>
                            @else
                                <img src="{{ $delegate->getAvatar() }}"
                                     class="img img-size-64"
                                     alt="{{ $delegate->name }}">
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>

                @slot('footer')
                    @include('dashboard.accounts.delegates.partials.actions.edit')
                    @include('dashboard.accounts.delegates.partials.actions.delete')
                    @include('dashboard.accounts.delegates.partials.actions.restore')
                    @include('dashboard.accounts.delegates.partials.actions.forceDelete')
                @endslot
            @endcomponent
        </div>
        <div class="col-md-6">
            @component('dashboard::components.box')
                @slot('class', 'p-0')
                @slot('bodyClass', 'p-0')
                <div class="d-flex align-items-center justify-content-between p-4">
                    <p class="mb-0 lead text-center">
                        @lang('delegates.balance'): <span class="badge badge-success">{{ price($balance) }}</span>
                    </p>
                    @if($balance)
                        <a class="btn btn-primary btn-sm" href="{{ route('dashboard.delegates.collect', $delegate) }}">
                            @lang('shops.collect')
                        </a>
                    @endif
                </div>

            @endcomponent
            @if($collected->count())
                @component('dashboard::components.box')
                    @slot('title', trans('delegates.transactions'))
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
