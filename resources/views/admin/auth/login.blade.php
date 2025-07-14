@extends('admin.auth.app')
@section('title')
    Login
@endsection
@section('auth')
    <!-- Nested Row within Card Body -->
    <div class="row">
        <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center bg-white">
            <img src="{{ asset($Settings->logo) }}" alt="Login Image" class="img-fluid"
                style="max-width: 80%; max-height: 80%;">
        </div>
        <div class="col-lg-6">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                </div>
                <form class="user" action="{{ route('admin.login.check') }}" method="Post">
                    @csrf
                    <div class="form-group">
                        <input name="email" type="email" class="form-control form-control-user" id="exampleInputEmail"
                            aria-describedby="emailHelp" placeholder="Enter Email Address...">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input name="password" type="password" class="form-control form-control-user"
                            id="exampleInputPassword" placeholder="Password">
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                            <input name="remember" type="checkbox" class="custom-control-input" id="customCheck">
                            <label class="custom-control-label" for="customCheck">Remember
                                Me</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Login
                    </button>


                </form>
                <hr>
                <div class="text-center">
                    <a class="small" href="{{ route('admin.password.showEmail') }}">Forgot Password?</a>
                </div>

            </div>
        </div>
    </div>
@endsection
