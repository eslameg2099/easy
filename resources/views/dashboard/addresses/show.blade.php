<x-layout :title="$address->name" :breadcrumbs="['dashboard.addresses.show', $address]">
    <div class="row">
        <div class="col-md-9">
            @component('dashboard::components.box')
                @slot('class', 'p-0')
                @slot('bodyClass', 'p-0')

                <table class="table table-striped table-middle">
                    <tbody>
                    <tr>
                        <th width="200">@lang('addresses.attributes.name')</th>
                        <td>{{ $address->name }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('addresses.attributes.address')</th>
                        <td>{{ $address->address }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('addresses.attributes.lat')</th>
                        <td>{{ $address->lat }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('addresses.attributes.lng')</th>
                        <td>{{ $address->lng }}</td>
                    </tr>
                    <tr>
                    <th width="200">@lang('admins.attributes.fulladd')</th>
                       
                       <td>{{ $address->cities[0]->name ?? '_'  }} /{{ $address->cities[1]->name ?? '_'  }}/ {{ $address->cities[2]->name ?? '_'  }}/ {{ $address->cities[3]->name ?? '_'  }} </td>
                   </tr>
                    </tbody>
                </table>

                @slot('footer')
                    @include('dashboard.addresses.partials.actions.edit')
                    @include('dashboard.addresses.partials.actions.delete')
                  
                @endslot
            @endcomponent
        </div>
    </div>
</x-layout>
