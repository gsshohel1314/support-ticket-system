@switch($ticket->priority)
    @case("low")
            <span class="badge badge-success">{{ __('Low') }}</span>
        @break
    @case("medium")
            <span class="badge badge-warning">{{ __('Medium') }}</span>
        @break
    @case("high")
            <span class="badge badge-danger">{{ __('High') }}</span>
        @break
    @default
@endswitch