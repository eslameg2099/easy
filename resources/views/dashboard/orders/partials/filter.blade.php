{{ BsForm::resource('orders')->get(url()->current()) }}
@component('dashboard::components.box')
    @slot('title', trans('orders.filter'))

    <div class="row">
        <div class="col-md-4">
            {{ BsForm::number('id')->value(request('id')) }}
        </div>
        <div class="col-md-4">
            {{ BsForm::select('status')->placeholder(trans('orders.actions.list'))->options(trans('orders.filters'))->value(request('status')) }}
        </div>
        <div class="col-md-4">
            {{ BsForm::number('perPage')
                ->value(request('perPage', 15))
                ->min(1)
                 ->label(trans('orders.perPage')) }}
        </div>
    </div>

    @slot('footer')
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('orders.actions.filter')
        </button>
    @endslot
@endcomponent
{{ BsForm::close() }}
