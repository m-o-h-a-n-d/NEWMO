@extends('admin.auth.app')

{{-- start title --}}
@section('title')
    Reset
@endsection
{{-- End Title --}}

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
                    <h1 class="h4 text-gray-900 mb-4">Reset password </h1>
                </div>
                <form class="user" action="{{ route('admin.password.sendReset') }}" method="Post">
                    @csrf
                    <div class="form-group">
                        <input hidden name="email" type="email" class="form-control form-control-user"
                            id="exampleInputEmail" aria-describedby="emailHelp" value="{{ $email }}">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input name="password" type="password" class="form-control form-control-user"
                            id="exampleInputPassword" required autocomplete="new-password" placeholder="Password">
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input name="password_confirmation" type="password" class="form-control form-control-user"
                            id="exampleInputPassword" required autocomplete="new-password"
                            placeholder="password_confirmation">
                        @error('password_confirmation')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Reset
                    </button>


                </form>


            </div>
        </div>
    </div>
@endsection
