@can('delete', $address)
    <a href="#address-{{ $address->id }}-delete-model"
       class="btn btn-outline-danger btn-sm"
       data-toggle="modal">
        <i class="fas fa fa-fw fa-trash"></i>
    </a>


    <!-- Modal -->
    <div class="modal fade" id="address-{{ $address->id }}-delete-model" tabindex="-1" role="dialog"
         aria-labelledby="modal-title-{{ $address->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title-{{ $address->id }}">@lang('addresses.dialogs.delete.title')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @lang('addresses.dialogs.delete.info')
                </div>
                <div class="modal-footer">
                    {{ BsForm::delete(route('dashboard.addresses.destroy', $address)) }}
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('addresses.dialogs.delete.cancel')
                    </button>
                    <button type="submit" class="btn btn-danger">
                        @lang('addresses.dialogs.delete.confirm')
                    </button>
                    {{ BsForm::close() }}
                </div>
            </div>
        </div>
    </div>
@endcan
