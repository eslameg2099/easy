@include('dashboard.errors')

@bsMultilangualFormTabs
{{ BsForm::text('name') }}
@endBsMultilangualFormTabs
{{ BsForm::number('shipping_cost') }}


<input Type="hidden" name="parent_id" value="">
