@extends('layouts.frontend.app')

{{--  Breadcrumb start  --}}
@section('breadcrumb')
    {{--  empty to prevent breadcrumb in home page  --}}
@endsection
{{--  Breadcrumb End  --}}

{{-- title --}}

@section('title')

        Verify 
@endsection



@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow rounded-4 border-0">
                    <div class="card-header bg-white border-bottom-0 text-center">
                        <h4 class="text-danger fw-bold mb-0">{{ __('Verify Your Email Address') }}</h4>
                    </div>

                    <div class="card-body text-center px-4 py-5">
                        @if (session('resent'))
                            <div class="alert alert-success rounded-3 shadow-sm" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif

                        <p class="mb-3 text-muted">
                            {{ __('Before proceeding, please check your email for a verification link.') }}
                        </p>

                        <p class="text-muted">
                            {{ __('If you did not receive the email, you can request another one:') }}
                        </p>

                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary mt-3 shadow-sm rounded-pill px-4">
                                {{ __('Click here to request another') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
