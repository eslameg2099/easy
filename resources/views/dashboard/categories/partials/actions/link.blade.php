@if($category)
    @if(method_exists($category, 'trashed') && $category->trashed())
        <a href="{{ route('dashboard.categories.trashed.show', $category) }}" class="text-decoration-none text-ellipsis">
            {{ $category->name }}
        </a>
    @else
        <a href="{{ route('dashboard.categories.show', $category) }}" class="text-decoration-none text-ellipsis">
            {{ $category->name }}
        </a>
    @endif
@else
    ---
@endif