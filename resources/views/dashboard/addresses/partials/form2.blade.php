@include('dashboard.errors')

{{ BsForm::text('name') }}
{{ BsForm::text('address') }}
{{ BsForm::text('lat') }}
{{ BsForm::text('lng') }}


<h5>@lang('cities.attributes.name') </h5>

<city-select value="{{ $address->city_id ?? old('city_id') }}"></city-select>

