@include('dashboard.errors')
{{ BsForm::text('name') }}
{{ BsForm::text('email') }}
{{ BsForm::text('phone') }}
{{ BsForm::password('password') }}
{{ BsForm::password('password_confirmation') }}
{{ BsForm::text('national_id') }}
{{ BsForm::text('vehicle_type') }}
{{ BsForm::text('vehicle_model') }}
{{ BsForm::text('vehicle_number') }}
{{ BsForm::checkbox('is_available')->withDefault()->value(1)->checked($delegate->is_available ?? old('is_available')) }}
{{ BsForm::checkbox('is_approved')->withDefault()->value(1)->checked($delegate->is_approved ?? old('is_approved')) }}

<h5>@lang('cities.attributes.name') </h5>
<city-select value="{{ $delegate->city_id ?? old('city_id') }}"></city-select>



<div class="row">
    <div class="col-md-6">
        @isset($delegate)
            {{ BsForm::image('avatar')->collection('avatars')->files($delegate->getMediaResource('avatars')) }}
        @else
            {{ BsForm::image('avatar')->collection('avatars') }}
        @endisset
    </div>
    <div class="col-md-6">
        @isset($delegate)
            {{ BsForm::image('vehicle_image')->collection('vehicle_image')->files($delegate->getMediaResource('vehicle_image')) }}
        @else
            {{ BsForm::image('vehicle_image')->collection('vehicle_image') }}
        @endisset
    </div>
    <div class="col-md-6">
        @isset($delegate)
            {{ BsForm::image('national_front_image')->collection('national_front_image')->files($delegate->getMediaResource('national_front_image')) }}
        @else
            {{ BsForm::image('national_front_image')->collection('national_front_image') }}
        @endisset
    </div>
    <div class="col-md-6">
        @isset($delegate)
            {{ BsForm::image('national_back_image')->collection('national_back_image')->files($delegate->getMediaResource('national_back_image')) }}
        @else
            {{ BsForm::image('national_back_image')->collection('national_back_image') }}
        @endisset
    </div>
</div>
