@switch($ticket->status)
    @case("pending")
            <span class="badge badge-warning">{{ __('Pending') }}</span>
        @break
    @case("ongoing")
            <span class="badge badge-primary">{{ __('Ongoing') }}</span>
        @break
    @case("rejected")
            <span class="badge badge-danger">{{ __('Rejected') }}</span>
        @break
    @case("completed")
            <span class="badge badge-success">{{ __('Completed') }}</span>
        @break

    @default
@endswitch
