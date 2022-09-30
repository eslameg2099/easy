@if(method_exists($address, 'trashed') && $address->trashed())
    @can('view', $address)
        <a href="{{ route('dashboard.addresses.trashed.show', $address) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@else
    @can('view', $address)
        <a href="{{ route('dashboard.addresses.show', $address) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@endif