@extends('layouts.backend.app')

@section('admin_title')
    Verify OTP
@endsection

@section('body')
    <div class="container">
        <div class="row justify-content-center">
            <h2 class="text-center w-100" style="font-size: 40px">Verify OTP</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mb-5 shadow">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.profile.verify-otp') }}">
                            @csrf

                            {{-- Email (hidden) --}}
                            <input type="hidden" name="email" value="{{ auth('admin')->user()->email }}">

                            {{-- OTP Input --}}
                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-3">
                                    <label for="token" class="form-label">OTP <span class="text-danger">*</span></label>
                                    <input name="token" type="text" class="form-control" placeholder="Enter OTP" required>
                                    @error('token')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-success px-5 py-2">Verify & Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
