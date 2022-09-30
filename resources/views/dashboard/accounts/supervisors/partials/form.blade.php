@include('dashboard.errors')
{{ BsForm::text('name') }}
{{ BsForm::text('email') }}
{{ BsForm::text('phone') }}
{{ BsForm::password('password') }}
{{ BsForm::password('password_confirmation') }}
<h5>@lang('cities.attributes.name') </h5>

<city-select value="{{ $supervisor->city_id ?? old('city_id') }}"></city-select>

@if(auth()->user()->isAdmin())
    <fieldset>
        <legend>@lang('permissions.plural')</legend>
        @foreach(config('permission.supported') as $permission)
            {{ BsForm::checkbox('permissions[]')
                    ->value($permission)
                    ->label(trans(str_replace('manage.', '', $permission.'.permission')))
                    ->checked(isset($supervisor) && $supervisor->hasPermissionTo($permission)) }}
        @endforeach
    </fieldset>
@endif

@isset($supervisor)
    {{ BsForm::image('avatar')->collection('avatars')->files($supervisor->getMediaResource('avatars')) }}
@else
    {{ BsForm::image('avatar')->collection('avatars') }}
@endisset
