@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">

                        {{-- Header --}}
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-primary">Confirm Your Password</h2>
                            <p class="text-muted">Please confirm your password before continuing.</p>
                        </div>

                        {{-- Form --}}
                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            {{-- Password --}}
                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password">
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Submit --}}
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Confirm Password
                                </button>
                            </div>

                            {{-- Forgot Password --}}
                            @if (Route::has('password.request'))
                                <div class="text-center mt-3">
                                    <a class="text-decoration-none" href="{{ route('password.request') }}">
                                        Forgot Your Password?
                                    </a>
                                </div>
                            @endif
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
