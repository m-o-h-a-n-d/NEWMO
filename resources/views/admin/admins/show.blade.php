@extends('layouts.backend.app')

@section('admin_title')
    Update Admin
@endsection

@section('body')
    <div class="container">
        <div class="row justify-content-center">
            <h2 class="text-center w-100" style="font-size: 40px">Update Admin</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mb-5 shadow">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.admins.update', $admin->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            {{-- Preview Current Image --}}
                            <div class="row mb-4 justify-content-center">
                                <div class="col-md-6 text-center">
                                    <div id="profile-image-preview" class="position-relative mb-3">
                                        <img id="preview-img" src="{{ asset($admin->image) }}" alt="Profile Image"
                                            class="rounded-circle shadow border border-3"
                                            style="width: 160px; height: 160px; object-fit: cover; transition: 0.3s;">

                                        <button type="button" id="remove-image"
                                            class="btn btn-sm btn-danger position-absolute"
                                            style="top: 0; right: 0; transform: translate(50%, -50%); display: none;">
                                            ×
                                        </button>
                                    </div>


                                </div>
                            </div>

                            {{-- Name / Username / Email --}}
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="name" class="col-form-label">Full Name <span
                                            class="text-danger">*</span></label>
                                    <input id="name" type="text" class="form-control" name="name"
                                        value="{{ $admin->name }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="username" class="col-form-label">Username <span
                                            class="text-danger">*</span></label>
                                    <input id="username" type="text" class="form-control" name="username"
                                        value="{{ $admin->username }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="email" class="col-form-label">Email Address <span
                                            class="text-danger">*</span></label>
                                    <input id="email" type="email" class="form-control" name="email"
                                        value="{{ $admin->email }}" required>
                                </div>
                            </div>

                            {{-- Role / Status --}}
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="status" class="col-form-label">Status <span
                                            class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="1" {{ $admin->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $admin->status == 0 ? 'selected' : '' }}>Not Available
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="role_id" class="col-form-label">Role <span
                                            class="text-danger">*</span></label>
                                    <select name="role_id" id="role_id" class="form-control" required>
                                        <option value="">--- Select Role ---</option>
                                        @foreach ($authorization as $auth)
                                            <option value="{{ $auth->id }}"
                                                {{ $admin->role_id == $auth->id ? 'selected' : '' }}>
                                                {{ $auth->role }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
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
                            <label for="profile-image-upload"
                                class="d-flex flex-column align-items-center justify-content-center border border-2 border-dashed rounded p-4 text-center w-100"
                                style="cursor: pointer; background-color: #f9f9f9; min-height: 150px;">
                                <i class="bi bi-cloud-arrow-up-fill" style="font-size: 2rem; color: #007bff;"></i>
                                <span class="mt-2">Click or Drop New Image</span>
                                <small class="text-muted">Supports JPG, PNG</small>
                                <input type="file" accept="image/*" id="profile-image-upload" name="image"
                                    class="d-none">
                            </label>

                            @error('image')
                                <span class="text-danger d-block mt-2">{{ $message }}</span>
                            @enderror


                            {{-- Buttons --}}
                            <div class="row">
                                <div class="col-md-12 text-center mt-4">
                                    <button type="submit" class="btn btn-primary px-5 py-2">Update Admin</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Image Preview Script --}}
@push('js')
    <script>
        const fileInput = document.getElementById('profile-image-upload');
        const previewImage = document.getElementById('preview-img');
        const removeButton = document.getElementById('remove-image');
        const originalImage = previewImage.src;

        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file && file.type.startsWith("image/")) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    removeButton.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });

        removeButton.addEventListener('click', function() {
            fileInput.value = "";
            previewImage.src = originalImage;
            this.style.display = 'none';
        });
    </script>
@endpush
