@extends('layouts.frontend.app')

@section('breadcrumb')
@endsection

@section('title')
    Login
@endsection

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        {{-- Header --}}
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-primary">Welcome Back</h2>
                            <p class="text-muted">Login to continue</p>
                        </div>

                        {{-- Session Status --}}
                        @if (session('status'))
                            <div class="alert alert-info d-flex align-items-center">
                                <i class="fas fa-envelope me-2 text-primary"></i>
                                <div>
                                    {{ session('status') }}
                                    <a href="https://mail.google.com" target="_blank"
                                        class="ms-2 text-decoration-underline">
                                        Check your inbox
                                    </a>
                                </div>
                            </div>
                        @endif

                        {{-- Form --}}
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Remember + Forgot --}}
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-decoration-none">
                                        {{ __('Forgot Password?') }}
                                    </a>
                                @endif
                            </div>

                            {{-- Login Button --}}
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    {{ __('Login') }}
                                </button>
                            </div>

                            {{-- Register --}}
                            <div class="text-center mb-4">
                                <a href="{{ route('register') }}" class="text-decoration-none">
                                    {{ __("Don't have an account? Sign up") }}
                                </a>
                            </div>

                            <hr>

                            {{-- Social Login Icons --}}
                            <div class="text-center mb-3  text-muted">Or login with</div>
                            <div class="d-flex justify-content-around gap-3 m-auto w-50">
                                <a href="{{ route('social.redirect', 'google') }}" class="btn rounded-circle text-white"
                                    style="background-color: #DB4437; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fab fa-google fs-5"></i>
                                </a>

                                <a href="{{ route('social.redirect', 'facebook') }}" class="btn rounded-circle text-white"
                                    style="background-color: #3b5998; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fab fa-facebook-f fs-5"></i>
                                </a>

                                <a href="{{ route('social.redirect', 'github') }}" class="btn rounded-circle text-white"
                                    style="background-color: #333; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fab fa-github fs-5"></i>
                                </a>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
