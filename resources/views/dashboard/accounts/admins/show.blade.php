<x-layout :title="$admin->name" :breadcrumbs="['dashboard.admins.show', $admin]">
    @component('dashboard::components.box')
        @slot('bodyClass', 'p-0')

        <table class="table table-striped table-middle">
            <tbody>
            <tr>
                <th width="200">@lang('admins.attributes.name')</th>
                <td>{{ $admin->name }}</td>
            </tr>
            <tr>
                <th width="200">@lang('admins.attributes.email')</th>
                <td>{{ $admin->email }}</td>
            </tr>
            <tr>
                <th width="200">@lang('admins.attributes.phone')</th>
                <td>{{ $admin->getPhone() }}</td>
            </tr>
            <tr>
                    <th width="200"> @lang('admins.attributes.fulladd')  </th>
                       
                        <td>{{ $admin->cities[0]->name ?? '_'  }} /{{ $admin->cities[1]->name ?? '_'  }}/ {{ $admin->cities[2]->name ?? '_'  }}/ {{ $admin->cities[3]->name ?? '_'  }} </td>
                    </tr>
            @if($city = $admin->city)
                <tr>
                    <th width="200">@lang('cities.select')</th>
                    <td>
                        @include('dashboard.cities.partials.actions.link', compact('city'))
                    </td>
                </tr>
            @endif
            <tr>
                <th width="200">@lang('admins.attributes.avatar')</th>
                <td>
                    @if($admin->getFirstMedia('avatars'))
                        <file-preview :media="{{ $admin->getMediaResource('avatars') }}"></file-preview>
                    @else
                        <img src="{{ $admin->getAvatar() }}"
                             class="img img-size-64"
                             alt="{{ $admin->name }}">
                    @endif
                </td>
            </tr>
            </tbody>
        </table>

        @slot('footer')
            @include('dashboard.accounts.admins.partials.actions.edit')
            @include('dashboard.accounts.admins.partials.actions.delete')
            @include('dashboard.accounts.admins.partials.actions.restore')
            @include('dashboard.accounts.admins.partials.actions.forceDelete')
        @endslot
    @endcomponent
</x-layout>
