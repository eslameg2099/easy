<x-layout :title="$customer->name" :breadcrumbs="['dashboard.customers.show', $customer]">
    @component('dashboard::components.box')
        @slot('bodyClass', 'p-0')

        <table class="table table-striped table-middle">
            <tbody>
            <tr>
                <th width="200">@lang('customers.attributes.name')</th>
                <td>{{ $customer->name }}</td>
            </tr>
            <tr>
                <th width="200">@lang('customers.attributes.email')</th>
                <td>{{ $customer->email }}</td>
            </tr>
            <tr>
                <th width="200">@lang('customers.attributes.phone')</th>
                <td>
                    @include('dashboard.accounts.customers.partials.flags.phone')
                </td>
            </tr>
            <tr>
                    <th width="200">@lang('admins.attributes.fulladd') </th>
                       
                        <td>{{ $customer->cities[0]->name ?? '_'  }} /{{ $customer->cities[1]->name ?? '_'  }}/ {{ $customer->cities[2]->name ?? '_'  }}/ {{ $customer->cities[3]->name ?? '_'  }} </td>
                    </tr>
            @if($city = $customer->city)
                <tr>
                    <th width="200">@lang('cities.select')</th>
                    <td>
                        @include('dashboard.cities.partials.actions.link', compact('city'))
                    </td>
                </tr>
            @endif
            <tr>
           
                <th width="200">@lang('customers.attributes.avatar')</th>
                <td>
                    @if($customer->getFirstMedia('avatars'))
                        <file-preview :media="{{ $customer->getMediaResource('avatars') }}"></file-preview>
                    @else
                        <img src="{{ $customer->getAvatar() }}"
                             class="img img-size-64"
                             alt="{{ $customer->name }}">
                    @endif
                </td>
            </tr>
          
            </tbody>
        </table>

        @slot('footer')
            @include('dashboard.accounts.customers.partials.actions.edit')
            @include('dashboard.accounts.customers.partials.actions.delete')
            @include('dashboard.accounts.customers.partials.actions.restore')
            @include('dashboard.accounts.customers.partials.actions.forceDelete')
        @endslot
        @endcomponent
        @component('dashboard::components.table-box')

@slot('title')
    @lang('addresses.plural') ({{ count_formatted($addresses->total()) }})
@endslot
        <thead>
        <tr>
            <th colspan="100">
                <div class="d-flex">
                  

                <a href="{{ route('dashboard.addresses.create', $customer->id) }}" class="btn btn-outline-success btn-sm">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('addresses.actions.create')
    </a>
                </div>
            </th>
        </tr>
        <tr>
           
            <th>#</th>
            <th>@lang('addresses.attributes.name')</th>
        </tr>
        </thead>
        <tbody>
        @forelse($addresses as $address )
            <tr>
               
                <td>
                   
                        {{ $address ->id }}
                    
                </td>
                <td>
                   
                   {{ $address->name }}
               
           </td>
           <td style="width: 160px">
                    @include('dashboard.addresses.partials.actions.show')
                    @include('dashboard.addresses.partials.actions.edit')
                    @include('dashboard.addresses.partials.actions.delete')
                </td>
              
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('customers.empty')</td>
            </tr>
        @endforelse

        @if($addresses->hasPages())
            @slot('footer')
                {{ $addresses->links() }}
            @endslot
        @endif



        @endcomponent



       
</x-layout>
