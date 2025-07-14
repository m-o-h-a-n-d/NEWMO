@extends('layouts.backend.app')

{{-- Title Of Page --}}
@section('admin_title')
    Edit Role permission
@endsection

{{-- Body of the Page --}}
@section('body')
    <div class="container">
        <div class="row justify-content-center">
            <h2 class="text-center w-100 mb-4" style="font-size: 40px">Edit Admin Permission</h2>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow mb-5">
                    <div class="card-body p-4">



                        {{-- Form --}}
                        <form method="POST" action="{{ route('admin.authorize.update', $authorize->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            {{-- Role Input --}}
                            <div class="mb-4">
                                <label for="role" class="form-label fw-bold">Role <span
                                        class="text-danger">*</span></label>
                                <input id="role" type="text"
                                    class="form-control @error('role') is-invalid @enderror" name="role"
                                    value="{{ $authorize->role }}" required autofocus>

                                @error('role')
                                    <span class="invalid-feedback d-block mt-1" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Permissions Checkboxes --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold">Select Permissions</label>
                                <div class="row">

                                    @foreach (config('autharization.permission') as $key => $permission)
                                        <div class="col-md-4 col-sm-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                                    value="{{ $key }}" id="{{ $key }}"
                                                    @checked(in_array($key, $authorize->permissions))>
                                                <label class="form-check-label" for="{{ $key }}">
                                                    {{ $permission }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary px-4 py-2">
                                    <i class="fas fa-upload me-2 "></i> update Role
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
