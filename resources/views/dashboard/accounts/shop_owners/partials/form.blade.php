@include('dashboard.errors')
{{ BsForm::text('name') }}
{{ BsForm::text('email') }}
{{ BsForm::text('phone') }}
{{ BsForm::number('tax')->step('any') }}

{{ BsForm::password('password') }}
{{ BsForm::password('password_confirmation') }}
<h5>@lang('cities.attributes.name') </h5>

<city-select value="{{ $shopOwner->city_id ?? old('city_id') }}"></city-select>


@isset($shopOwner)
    {{ BsForm::image('avatar')->collection('avatars')->files($shopOwner->getMediaResource('avatars')) }}
@else
    {{ BsForm::image('avatar')->collection('avatars') }}
@endisset
