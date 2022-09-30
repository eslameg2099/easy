@include('dashboard.errors')


<input type="hidden"  name="user_id" value="{{$ShopOwner->id}}">

{{ BsForm::text('name') }}
{{ BsForm::textarea('description') }}
@isset($shop)
 القسم الحالي: {{$shop->category->name}}
 @endisset
<select2
        name="category_id"
        label="@lang('categories.select')"
        remote-url="{{ route('api.categories.select2', ['parents' => 1]) }}"
        value="{{ $shop->category_id ?? old('category_id') }}"
></select2>
{{ BsForm::checkbox('free_shipping')->value(1)->withDefault()->checked($shop->free_shipping ?? old('free_shipping')) }}

@isset($shop)
    {{ BsForm::image('logo')->collection('logo')->files($shop->getMediaResource('logo')) }}
    {{ BsForm::image('banner')->collection('banner')->files($shop->getMediaResource('banner')) }}
@else
    {{ BsForm::image('logo')->collection('logo') }}
    {{ BsForm::image('banner')->collection('banner') }}
@endisset

