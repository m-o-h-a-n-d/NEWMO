@extends('layouts.backend.app')

{{-- Title Of Page --}}
@section('admin_title')
    Create Mail
@endsection

{{-- Body of the Page --}}
@section('body')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-10">
                <div class="card shadow rounded-3">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0 text-center">Create New MAIL</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.mails.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="admin_id" value="{{ Auth::guard('admin')->user()->id}}">

                            <!-- Post Title -->
                            <div class="form-group">
                                <label for="postTitle" class="font-weight-bold">Mail Title</label>
                                <textarea id="postTitle" class="form-control" name="title" rows="3" placeholder="Enter post title..." required></textarea>
                            </div>

                            <!-- Role Selection -->
                            <div class="form-group">
                                <label for="role_id" class="font-weight-bold">Role <span
                                        class="text-danger">*</span></label>
                                <select name="role_id" id="role_id"
                                    class="form-control @error('role') is-invalid @enderror" required>
                                    <option value="">--- Select Role ---</option>
                                    @forelse ($authorize as $auth)
                                        <option value="{{ $auth->id }}">{{ $auth->role }}</option>
                                    @empty
                                        <option disabled>No Roles Available</option>
                                    @endforelse
                                </select>
                                @error('role')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="text-right">
                                <button type="submit" class="btn btn-success px-4 py-2">Send Email</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
