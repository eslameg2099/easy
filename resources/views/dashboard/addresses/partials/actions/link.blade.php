@if($address)
    @if(method_exists($address, 'trashed') && $address->trashed())
        <a href="{{ route('dashboard.addresses.trashed.show', $address) }}" class="text-decoration-none text-ellipsis">
            {{ $address->name }}
        </a>
    @else
        <a href="{{ route('dashboard.addresses.show', $address) }}" class="text-decoration-none text-ellipsis">
            {{ $address->name }}
        </a>
    @endif
@else
    ---
@endif