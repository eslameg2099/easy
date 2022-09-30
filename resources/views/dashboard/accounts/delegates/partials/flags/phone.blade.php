<div class="d-inline-flex align-items-center">
    <span class="mx-2">{{ $delegate->getPhone() }}</span>
    @if($delegate->phone_verified_at)
        <span class="badge badge-success">@lang('users.verified')</span>
    @else
        <span class="badge badge-warning">@lang('users.unverified')</span>
    @endif
</div>