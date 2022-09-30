{{ BsForm::resource('products')->get(url()->current()) }}
@component('dashboard::components.box')
    @slot('title', trans('products.filter'))
   
    <div class="row">
        <div class="col-md-3">
            {{ BsForm::text('name')->value(request('name')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::text('category_name')->value(request('category_name')) }}
        </div>

        <div class="col-md-3">
            {{ BsForm::text('shop_name')->value(request('shop_name')) }}
        </div>
        
      
        <div class="col-md-2">
            {{ BsForm::number('perPage')
                ->value(request('perPage', 15))
                ->min(1)
                 ->label(trans('products.perPage')) }}
        </div>
    </div>

    @slot('footer')
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('products.actions.filter')
        </button>
    @endslot
@endcomponent
{{ BsForm::close() }}
