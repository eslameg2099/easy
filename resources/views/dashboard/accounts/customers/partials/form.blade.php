@include('dashboard.errors')
{{ BsForm::text('name') }}
{{ BsForm::text('email') }}
{{ BsForm::text('phone') }}
{{ BsForm::password('password') }}
{{ BsForm::password('password_confirmation') }}
<h5>@lang('cities.attributes.name') </h5>

<city-select value="{{ $customer->city_id ?? old('city_id') }}"></city-select>

@isset($customer)
    {{ BsForm::image('avatar')->collection('avatars')->files($customer->getMediaResource('avatars')) }}
@else
    {{ BsForm::image('avatar')->collection('avatars') }}
@endisset
