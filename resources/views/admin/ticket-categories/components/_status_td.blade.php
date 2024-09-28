<div class="badge @if($ticketCategory->status) badge-success @else badge-danger @endif">
    @if($ticketCategory->status)
        {{ __('Active') }}
    @else
        {{ __('Inactive') }}
    @endif
</div>

