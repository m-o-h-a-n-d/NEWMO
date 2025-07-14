@extends('layouts.backend.app')

@section('admin_title')
    Admin
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
                                        value="{{ $admin->name }}" readonly required>
                                </div>
                                <div class="col-md-4">
                                    <label for="username" class="col-form-label">Username <span
                                            class="text-danger">*</span></label>
                                    <input id="username" type="text" class="form-control" name="username"
                                        value="{{ $admin->username }}"readonly required>
                                </div>
                                <div class="col-md-4">
                                    <label for="email" class="col-form-label">Email Address <span
                                            class="text-danger">*</span></label>
                                    <input id="email" type="email" class="form-control" name="email"
                                        value="{{ $admin->email }}"readonly required>
                                </div>
                            </div>

                            {{-- Role / Status --}}
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="status" class="col-form-label">Status <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="status" id="status"
                                        value="{{ $admin->status = 0 ? 'Non Available' : 'Active' }}" class="form-control"
                                        required readonly>


                                </div>
                                @php
                                    $adminRole = optional($authorization->firstWhere('id', $admin->role_id))->role;
                                @endphp

                                <div class="col-md-6">
                                    <label for="role_id" class="col-form-label">Role <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="role_id" id="role_id" value="{{ $adminRole }}"
                                        class="form-control" required readonly>
                                </div>

                            </div>
                    </div>
                </div>
                {{-- Password & confirm password --}}
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
