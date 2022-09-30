@include('dashboard.errors')
@bsMultilangualFormTabs

{{ BsForm::text('name') }}
{{ BsForm::textarea('description')->attribute('class', 'textarea') }}
@endBsMultilangualFormTabs

{{ BsForm::number('price')->min(1)->step('any') }}
{{ BsForm::number('offer_price')->min(1)->step('any') }}
{{ BsForm::number('quantity')->min(0) }}

<categories-select
        label="@lang('shops.singular')"
        placeholder="@lang('shops.select')"
        nested-label="@lang('categories.subcategory')"
        nested-placeholder="@lang('categories.select-subcategory')"
        value="{{ $product->shop_id ?? old('shop_id') }}"
        category-value="{{ $product->category_id ?? old('category_id') }}"
></categories-select>

<colors-component :colors="{{ isset($product) ? json_encode($product->colors) : '[]' }}"></colors-component>
<sizes-component :sizes="{{ isset($product) ? json_encode($product->sizes) : '[]' }}"></sizes-component>

@isset($product)
    {{ BsForm::image('images')->unlimited()->files($product->getMediaResource()) }}
@else
    {{ BsForm::image('images')->unlimited() }}
@endisset

