@extends('layouts.frontend.app')

@section('breadcrumb')
@endsection

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">

                        {{-- Header --}}
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-primary">Forgot Your Password?</h2>
                            <p class="text-muted">Enter your email to receive a password reset link.</p>
                        </div>

                        {{-- Session Alert --}}
                        @if (session('status'))
                            <div class="alert alert-success text-center" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{-- Form --}}
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            {{-- Email --}}
                            <div class="mb-4">
                                <label for="email" class="form-label">Email Address</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Submit --}}
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Send Reset Link
                                </button>
                            </div>
                        </form>

                        {{-- Back to login --}}
                        <div class="text-center mt-4">
                            <a href="{{ route('login') }}" class="text-decoration-none">
                                <i class="fas fa-arrow-left me-1"></i> Back to Login
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
