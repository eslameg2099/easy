@include('dashboard.errors')
{{ BsForm::text('name') }}
{{ BsForm::email('email')->required() }}
{{ BsForm::text('phone')->required() }}
{{ BsForm::password('password') }}
{{ BsForm::password('password_confirmation') }}
<h5>@lang('cities.attributes.name') </h5>

<city-select value="{{ $admin->city_id ?? old('city_id') }}"></city-select>

@isset($admin)
    {{ BsForm::image('avatar')->collection('avatars')->files($admin->getMediaResource('avatars')) }}
@else
    {{ BsForm::image('avatar')->collection('avatars') }}
@endisset
