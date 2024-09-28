@extends('layouts.auth.layout')
@section('title', 'Login')
@section('mainContent')
    <div class="d-flex flex-column flex-column-fluid flex-lg-row">
        <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
            <div class="d-flex flex-center flex-lg-start flex-column">
                <a href="javascript:void(0);" class="mb-7">
                    <h2 class="text_logo text_40">{{ __('SUPPORT TICKET') }} </h2>
                </a>
            </div>
        </div>
        <div class="d-flex flex-center w-lg-50 p-10">
            <div class="card rounded-3 w-md-550px">
                <div class="card-body p-10 p-lg-20">
                    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="POST" action="{{ route('admin.login') }}">
                        @csrf
                        <div class="text-center mb-11">
                            <h1 class="text-dark fw-bolder mb-3">{{__('Admin Login')}}</h1>
                        </div>
                        <div class="fv-row mb-8">
                            <input id="email" type="email" placeholder="Email" name="email" autocomplete="false"
                                class="form-control bg-transparent @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" required />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="fv-row mb-3">
                            <input id="password" type="password" placeholder="Password" name="password" name="password"
                                required autocomplete="current-password"
                                class="form-control bg-transparent @error('password') is-invalid @enderror" />
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="d-grid mb-10">
                            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                <span class="indicator-label">{{__('Login')}}</span>
                                <span class="indicator-progress">{{__('Please wait')}}
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
