<div class="card-body py-3">
    <h4 class="mt-5">{{ __('Ticket Info') }}</h4>
    <div class="mt-5 d-flex align-items-center flex-row justify-content-between">
        <p class="fs-5">{{ __('Ticket Id') }} : </p>
        <p class="fs-5 ms-5">{{ $ticket->ticket_id }}</p>
    </div>
    <div class="d-flex align-items-center flex-row justify-content-between">
        <p class="fs-5">{{ __('Subject') }} : </p>
        <p class="fs-5 ms-5">{{ $ticket->subject }}</p>
    </div>
    <div class="d-flex align-items-center flex-row justify-content-between">
        <p class="fs-5">{{ __('Priority') }} : </p>
        <p class="fs-5 ms-5">
            @include('user.tickets.components._priority_td',$ticket)
        </p>
    </div>
    <div class="d-flex align-items-center flex-row justify-content-between">
        <p class="fs-5">{{ __('Category') }} : </p>
        <p class="fs-5 ms-5">{{ $ticket->category->name }}</p>
    </div>
    <div class="d-flex align-items-center flex-row justify-content-between">
        <p class="fs-5">{{ __('Status') }} : </p>
        <p class="fs-5 ms-5">
            @include('user.tickets.components._status_td',$ticket)
        </p>
    </div>
    <div class="d-flex align-items-center flex-row justify-content-between">
        <p class="fs-5">{{ __('User Name') }} : </p>
        <p class="fs-5 ms-5">
            @if($ticket->sender)
                {{ $ticket->sender->name }}
            @else
                Unknown
            @endif
        </p>
    </div>
    <div class="d-flex align-items-center flex-row justify-content-between">
        <p class="fs-5">{{ __('Submit Date') }} : </p>
        <p class="fs-5 ms-5">
            {{ $ticket->created_at->toFormattedDateString() }}</p>
    </div>
    <div class="d-flex align-items-center flex-row justify-content-between">
        <p class="fs-5">{{ __('Files') }} : </p>
        <p class="fs-5 ms-5">
            @foreach (json_decode($ticket->files) as $file)
            @php
                $fileName = explode('/', $file);
            @endphp
            <a download href="{{ asset('uploads/files/' . $file) }}">{{ end($fileName) }}</a> <br>
            @endforeach
        </p>
    </div>
</div>
