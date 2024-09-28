@extends('layouts.layout')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/summernote/summernote-lite.css') }}" type="text/css">
@endpush
@section('title')
    {{ __('Tickets') }}
@endsection
@section('mainContent')
    <div class="container d-flex flex-column flex-column-fluid">
        @include('includes.back',['route' => route('admin.tickets.index'),'title' => $ticket->ticket_id . " - ".$ticket->category->name])
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <div class="me-5 card mb-5 mb-xl-8">
                    @include('includes.ticket_sidebar',$ticket)
                </div>
            </div>
            <div class="col-sm-12 col-md-8">
                <div class="ms-5 me-5 card p-5 mb-5 mb-xl-8">
                    <div class="card-body rounded py-3 bg-secondary p-5">
                        <div class="mt-5">
                            <img src="{{ asset(@$ticket->sendable->avatar??'assets/media/avatars/blank.png') }}" class="w-50px h-50px" alt="customer-icon" />
                            <span class="ms-5 fw-bolder">{{ @$ticket->sender?->name??'' }}</span>
                        </div>
                        <div>
                            <p class="mt-3">{{ date('M d, Y h:i a', strtotime($ticket->created_at)) }}</p>
                        </div>
                        <div class="mt-5 w-100">
                            <p class="fs-5 ">{{$ticket->subject}}</p>
                            <p class="fs-5 ">{{$ticket->description}}</p>
                        </div>
                    </div>

                    {{-- Start::Count Total replay --}}
                    <div class="mt-5 accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="text-decoration-underline w-100 accordion-button" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    {{ __('Total replied in ticket') }} {{ $ticket->ticket_id }}: <span class="fw-bold ms-2">{{ count($ticketReplies) }}</span>
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body h-300px scroll-y" id="replyTicket">
                                    @foreach($ticketReplies as $reply)
                                        <div class="card-body rounded py-3 bordered p-5">
                                            <div class="mt-5">
                                                <img src="{{ !empty($reply->sender->avatar) ? url($reply->sender->avatar) : url('assets/media/avatars/blank.png') }}" class="w-50px h-50px" />
                                                <span class="ms-5 fw-bolder">{{ $reply->sender->name }}</span>
                                            </div>
                                            <div>
                                                <p class="mt-3">{{ date('M d, Y h:i a', strtotime($reply->created_at)) }}</p>
                                            </div>
                                            <div class="mt-5 w-100">
                                                <p class="">{!! $reply->message !!}</p>
                                                @foreach(json_decode($reply->files) as $file)
                                                    @php
                                                        $fileName = explode('/', $file);
                                                    @endphp
                                                    <a download href="{{asset('uploads/files/'.$file)}}">{{ end($fileName) }}</a> <br>
                                                @endforeach
                                            </div>
                                        </div>
                                        <hr />
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End::Count Total replay --}}
                    {{-- Start::Ticket replay --}}
                    <form action="{{ route('admin.ticket_reply') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="ticket_id" value="{{$ticket->id}}"/>
                        <input type="hidden" name="receiver_id" value="{{$ticket->sender_id}}"/>
                        <div class="card-body m-0 p-0 mt-5  w-100">
                            <label class="fs-6 fw-semibold form-label">
                                <span class="required">{{ __('Message') }}</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="Message is required"></i>
                            </label>
                            <textarea name="message" id="summernote" cols="30" rows="10" class="@error('message') is-invalid @enderror">
                                {{old('message')}}
                            </textarea>
                            @error('message')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="py-3">
                            <div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <label class="fs-5">{{ __('Attach file') }}</label>
                                        <div class="input-group mb-3">
                                            <input type="file" name="files[]" multiple class="form-control @error('files') is-invalid @enderror" id="inputGroupFile02">
                                            @error('files')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <label class="fs-5">{{ __('Status') }}</label>
                                        <div class="input-group mb-3">
                                            <select name="status" class="form-select form-select-solid" data-control="select2"
                                                data-placeholder="Select an option">
                                                <option></option>
                                                <option @if( $ticket->status == "ongoing") selected @endif value="ongoing">{{ __('Ongoing') }}</option>
                                                <option @if( $ticket->status == "pending") selected @endif value="pending">{{ __('Pending') }}</option>
                                                <option @if( $ticket->status == "completed") selected @endif value="completed">{{ __('Completed') }}</option>
                                            </select>
                                        </div>

                                    </div>

                                </div>
                                <button type="submit" class="mt-5 btn btn-primary">{{ __('Reply ticket') }}</button>
                            </div>
                        </div>
                    </form>
                    {{-- End::Ticket replay --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendors/summernote/summernote-lite.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Description',
                tabsize: 2,
                height: 200
            });
            var objDiv = document.getElementById("replyTicket");
            objDiv.scrollTop = objDiv.scrollHeight;
        });
    </script>
@endpush
