@can('viewAnyTrash', \App\Models\Address::class)
    <a href="{{ route('dashboard.addresses.trashed') }}" class="btn btn-outline-danger btn-sm">
        <i class="fas fa fa-fw fa-trash"></i>
        @lang('addresses.trashed')
    </a>
@endcan
