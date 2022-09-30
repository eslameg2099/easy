@include('dashboard.errors')
@bsMultilangualFormTabs
{{ BsForm::text('name')->required() }}
@endBsMultilangualFormTabs

{{ BsForm::checkbox('display_in_home')->value(1)->withDefault()->checked($category->display_in_home ?? old('display_in_home')) }}

@isset($category)
    {{ BsForm::image('image')->files($category->getMediaResource()) }}
    {{ BsForm::image('banner')->unlimited()->collection('banner')->files($category->getMediaResource('banner')) }}
@else
    {{ BsForm::image('image') }}
    {{ BsForm::image('banner')->unlimited()->collection('banner') }}
@endisset