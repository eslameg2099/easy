@include('dashboard.errors')

@bsMultilangualFormTabs
{{ BsForm::text('name') }}
@endBsMultilangualFormTabs
{{ BsForm::number('shipping_cost') }}
