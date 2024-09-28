@extends('layouts.layout')
@section('title')
    {{ __('Edit Ticket') }}
@endsection
@section('mainContent')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        {{ __('Edit Ticket') }}</h1>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{ route('user.tickets.index') }}"
                        class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary">{{ __('Ticket List') }}</a>
                </div>
            </div>
        </div>
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="row gx-5 gx-xl-10">
                    <div class="col-xxl-12 mb-5 mb-xl-12">
                        <div class="card card-flush h-xl-100 p-10">
                            <form id="kt_ecommerce_settings_general_form" class="form" method="POST"
                                action="{{ route('user.tickets.update') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $ticket->id }}">
                                <label class="fs-6 fw-semibold form-label">
                                    <span class="required">{{ __('Subject') }}</span>
                                </label>
                                <div class="input-group input-group-solid mb-5">
                                    <input required type="text" name="subject"
                                        class="form-control @error('subject') is-invalid @enderror" placeholder="Subject"
                                        aria-label="Subject" aria-describedby="basic-addon1"
                                        value="{{ old('subject') ? old('subject') : $ticket->subject }}" />
                                    @error('subject')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="row mb-5">
                                    <div class="col-sm-12 col-md-6">
                                        <label class="fs-6 fw-semibold form-label">
                                            <span class="required">{{ __('Ticket Category') }}</span>
                                        </label>
                                        <select required name="ticket_category"
                                            class="form-select form-select-solid @error('ticket_category') is-invalid @enderror"
                                            data-control="select2" data-placeholder="{{ __('Select a ticket category') }}">
                                            <option></option>
                                            @foreach ($ticketCategories as $category)
                                                <option value="{{ $category->id }}"
                                                    @if (old('ticket_category') && old('ticket_category') == $category->id) selected @elseif($category->id == $ticket->ticket_category_id) selected @endif>
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('ticket_category')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <label class="fs-6 fw-semibold form-label">
                                            <span class="required">{{ __('Priority') }}</span>
                                        </label>
                                        <select name="priority"
                                            class="form-select form-select-solid @error('priority') is-invalid @enderror"
                                            data-control="select2" data-placeholder="Select a priority">
                                            <option value="low"
                                                @if (old('priority') && old('priority') == 'low') selected @elseif($ticket->priority == 'low') selected @endif>
                                                {{ __('Low') }}</option>
                                            <option value="medium"
                                                @if (old('priority') && old('priority') == 'medium') selected @elseif($ticket->priority == 'medium') selected @endif>
                                                {{ __('Medium') }}</option>
                                            <option value="high"
                                                @if (old('priority') && old('priority') == 'high') selected @elseif($ticket->priority == 'high') selected @endif>
                                                {{ __('High') }}</option>
                                        </select>
                                        @error('priority')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <label class="fs-6 fw-semibold form-label">
                                    <span class="required">{{ __('Description') }}</span>
                                </label>
                                <div class="input-group input-group-solid mb-5">
                                    <textarea required name="description" type="text" class="form-control @error('description') is-invalid @enderror"
                                        rows="4" placeholder="Description" aria-label="Description" aria-describedby="basic-addon1">{{ old('description') ? old('description') : $ticket->description }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <label class="fs-6 fw-semibold form-label">
                                    <span class="required">{{ __('Files') }}</span>
                                </label>
                                <div class="input-group mb-3 w-100 mb-5">
                                    <input type="file" name="files[]" multiple
                                        class="form-control @error('files') is-invalid @enderror" id="inputGroupFile02">
                                    @error('files')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                @php
                                    $files = json_decode($ticket->files);
                                @endphp
                                @if (!empty($files))
                                    <label class="fs-6 fw-semibold form-label">
                                        <span>{{ __('File List') }}</span>
                                    </label>
                                    <div class="input-group mb-3 w-100 mb-5">
                                        <ul>
                                            @foreach ($files as $file)
                                                @php
                                                    $fileName = explode('/', $file);
                                                @endphp

                                                <li>
                                                    <a download
                                                        href="{{ asset('uploads/files/' . $file) }}">{{ end($fileName) }}</a>

                                                    <span><a href="#" class="text-danger remove-file"
                                                            data-id="{{ $ticket->id }}"
                                                            data-name="{{ $file }}">{{ __('Delete') }}</a></span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="d-flex justify-content-start">
                                    <button type="submit" id="kt_sign_in_submit"
                                        class="btn mt-5 btn-sm fw-bold btn-primary">
                                        <span class="indicator-label">{{ __('Save') }}</span>
                                        <span class="indicator-progress">{{ __('Please wait...') }}
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                    <a href="{{ url('/user/tickets') }}"
                                        class="btn btn-sm ms-3 btn-light mt-5 fw-bold btn-active-light-primary me-2">
                                        {{ __('Back') }}
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.remove-file', function(event) {
                event.preventDefault();
                let fileName = $(this).data('name');
                let id = $(this).data('id');
                Swal.fire({
                    text: "{{ __('Are you sure you want to delete selected file?') }}",
                    icon: "warning",
                    showCancelButton: !0,
                    buttonsStyling: !1,
                    confirmButtonText: "{{ __('Yes, delete!') }}",
                    cancelButtonText: "{{ __('No, cancel') }}",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    },
                }).then(function(o) {
                    if (o.value) {
                        var formData = new FormData();
                        formData.append('_token', "{{ csrf_token() }}");
                        formData.append('fileName', fileName);
                        formData.append('id', id);

                        $.ajax({
                            url: "{{ route('user.tickets.remove-file') }}",
                            type: "POST",
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            success: function(response) {
                                toastr.success(
                                    "{{ __('File has been removed successfully!') }}",
                                    "{{ __('Success') }}");
                                location.reload();
                            },
                            error: function(response) {
                                if (response.responseJSON.error) {
                                    toastr.error(response.responseJSON.error,
                                        "{{ __('Error') }}");
                                    return false;
                                }
                                toastr.error(
                                    "{{ __('Something went wrong!') }}",
                                    "{{ __('Error') }}");
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
