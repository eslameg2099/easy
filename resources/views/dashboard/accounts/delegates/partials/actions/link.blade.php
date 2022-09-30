@if($delegate)
    @if(method_exists($delegate, 'trashed') && $delegate->trashed())
        <a href="{{ route('dashboard.delegates.trashed.show', $delegate) }}" class="text-decoration-none text-ellipsis">
            {{ $delegate->name }}
            
        </a>
    @else
        <a href="{{ route('dashboard.delegates.show', $delegate) }}" class="text-decoration-none text-ellipsis">
            {{ $delegate->name }}
        </a>
    @endif
@else
    ---
@endif