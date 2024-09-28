@extends('layouts.layout')
@section('title')
{{ __('Create Ticket Category') }}
@endsection
@section('mainContent')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{__('Add Ticket Category')}}</h1>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="{{route('admin.ticket-categories.index')}}" class="btn btn-sm fw-bold bg-body btn-color-gray-700 btn-active-color-primary">{{__('Ticket Category List')}}</a>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="row gx-5 gx-xl-10">
                <div class="col-xxl-12 mb-5 mb-xl-12">
                    <div class="card card-flush h-xl-100 p-10">
                        <form id="kt_ecommerce_settings_general_form" class="form" method="POST" action="{{route('admin.ticket-categories.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-2">
                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <span class="required">{{__('Ticket Category Name')}}</span>
                                        </label>
                                        <input type="text" placeholder="{{__('Ticket Category Name')}}" class="form-control form-control-solid @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" />
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold mb-3 mt-3">
                                            <span>{{__('Active/ Inactive')}}</span>
                                        </label>
                                        <div class="mt-1">
                                            <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                                <input class="form-check-input h-20px w-30px status_shange" name="status" type="checkbox" checked value="1"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-start">
                                <button type="submit" id="kt_sign_in_submit" class="btn mt-5 btn-sm fw-bold btn-primary">
                                    <span class="indicator-label">{{__('Save')}}</span>
                                    <span class="indicator-progress">{{__('Please wait...')}}
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                                <a href="{{url('/admin/ticket-categories')}}" class="btn btn-sm ms-3 btn-light mt-5 fw-bold btn-active-light-primary me-2">
                                    {{__('Back')}}
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
