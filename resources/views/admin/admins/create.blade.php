@extends('layouts.backend.app')
{{-- Title Of Page  --}}
@section('admin_title')
    Create Admin
@endsection

{{-- Body of the Page  --}}
@section('body')
    <div class="container">
        <div class="row justify-content-center">
            <h2 class="text-center  w-100" style="font-size: 40px">Create Admin</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mb-5 shadow">
                    <div class="card-body ">
                        {{-- Optional image preview (below upload box) --}}
                        <div class=" mt-3" id="profile-image-preview" style="display: none;">
                            <img id="preview-img" src="#" alt="Profile Preview"
                                class="rounded shadow border border-2"
                                style="width: 130px; height: 130px; object-fit: cover;">
                            <br>
                            <button type="button" class="btn btn-sm btn-danger mt-2" id="remove-image">
                                Remove Image
                            </button>
                        </div>
                        <form method="POST" action="{{ route('admin.admins.store') }}" enctype="multipart/form-data">
                            @csrf
                            {{-- name & username & email --}}
                            <div class="row mb-3">
                                {{-- Full  Name --}}
                                <div class="col-md-4">
                                    <label for="name" class="col-form-label text-md-end">{{ __('Full Name') }}</label>
                                    <span style="color: red !important; display: inline; float: none;">*</span>
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                {{--  User Name --}}
                                <div class="col-md-4">
                                    <label for="username"class="col-form-label text-md-end">{{ __('username') }}</label>
                                    <span style="color: red !important; display: inline; float: none;">*</span>
                                    <input id="username" type="text"
                                        class="form-control @error('username') is-invalid @enderror" name="username"
                                        value="{{ old('username') }}" required autocomplete="name" autofocus>

                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                {{-- Email  --}}
                                <div class="col-md-4">
                                    <label for="email"
                                        class=" col-form-label text-md-end">{{ __('Email Address') }}</label>
                                    <span style="color: red !important; display: inline; float: none;">*</span>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- ======================================================== --}
                            {{-- Password & confirm password --}}
                            <div class="row mb-3">
                                {{-- Password --}}
                                <div class="col-md-6">
                                    <label for="password" class="col-form-label text-md-end">{{ __('Password') }}</label>
                                    <span style="color: red !important; display: inline; float: none;">*</span>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                {{-- Confirm  Password --}}
                                <div class="col-md-6">

                                    <label
                                        for="password-confirm"class=" col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                                    <span style="color: red !important; display: inline; float: none;">*</span>
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password" required>
                                </div>
                            </div>
                            {{-- ======================================================== --}}
                            {{--  status &Role  --}}
                            <div class="row mb-3">

                                {{-- status --}}
                                <div class="col-md-6">
                                    <label for="status">Status</label>
                                    <span style="color: red !important; display: inline; float: none;">*</span>
                                    <select name="status" id="status"
                                        class="form-control @error('status') is-invalid @enderror" required>
                                        <option value="">---Select Status---</option>
                                        <option value="1"  >Active</option>
                                        <option value="0" >Not Available</option>
                                    </select>
                                </div>
                                {{-- Role --}}
                                <div class="col-md-6">
                                    <label for="role_id">Role</label>
                                    <span style="color: red !important; display: inline; float: none;">*</span>
                                    <select name="role_id" id="role_id"
                                        class="form-control @error('role') is-invalid @enderror" required>
                                        <option value="">---Select Role---</option>
                                        @forelse ($authorize as $auth)
                                            <option value="{{ $auth->id }}" >{{ $auth->role }}</option>
                                        @empty
                                            <option>No Authorize</option>
                                        @endforelse
                                    </select>
                                </div>

                            </div>

                            {{-- ======================================================== --}}

                            {{-- Uploading Image --}}
                            <div class="row  mt-4">
                                <div class=" col-md-12">
                                    <label for="profile-image-upload" class="form-label fw-bold ">Upload
                                        Profile
                                        Image</label>
                                    <span style="color: red !important; display: inline; float: none;">*</span>

                                    <label for="profile-image-upload"
                                        class="d-flex flex-column align-items-center justify-content-center border border-2 border-dashed rounded p-4 text-center w-100"
                                        style="cursor: pointer; background-color: #f9f9f9; min-height: 180px;">
                                        <i class="bi bi-cloud-arrow-up-fill" style="font-size: 2rem; color: #007bff;"></i>
                                        <span class="mt-2">Drop images here or click to browse</span>
                                        <small class="text-muted">Supports JPG, PNG, GIF files</small>
                                        <input type="file" accept="image/*" id="profile-image-upload" name="image"
                                            class="d-none" required>
                                    </label>
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror


                                </div>
                            </div>


                            {{-- ======================================================== --}}
                            {{-- Button --}}
                            <div class="row  ">
                                <div class="col-md-12 offset-md-5 p-4">
                                    <button type="submit" class="btn btn-primary p-3 border-redis-3">
                                        {{ __('Create Admin') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Upload Image --}}
@push('js')
    <script>
        const fileInput = document.getElementById('profile-image-upload');
        const previewContainer = document.getElementById('profile-image-preview');
        const previewImage = document.getElementById('preview-img');
        const removeButton = document.getElementById('remove-image');

        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file && file.type.startsWith("image/")) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });

        removeButton.addEventListener('click', function() {
            fileInput.value = "";
            previewImage.src = "#";
            previewContainer.style.display = 'none';
        });
    </script>
@endpush
