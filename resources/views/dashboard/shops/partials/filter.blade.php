{{ BsForm::resource('shops')->get(url()->current()) }}
@component('dashboard::components.box')
    @slot('title', trans('shops.filter'))

    <div class="row">
        <div class="col-md-4">
            {{ BsForm::text('name')->value(request('name')) }}
        </div>
        <div class="col-md-4">
            {{ BsForm::text('category_name')->value(request('category_name')) }}
        </div>
        <div class="col-md-4">
            {{ BsForm::number('perPage')
                ->value(request('perPage', 15))
                ->min(1)
                 ->label(trans('shops.perPage')) }}
        </div>
    </div>

    
    @slot('footer')
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('shops.actions.filter')
        </button>
    @endslot
@endcomponent
{{ BsForm::close() }}
