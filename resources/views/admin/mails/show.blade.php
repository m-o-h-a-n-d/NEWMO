@extends('layouts.backend.app')

{{-- Title Of Page --}}
@section('admin_title')
    Show Contacts
@endsection

{{-- Body of the Page --}}
@section('body')
    <div class="container py-4">


        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow rounded">
                    {{-- ✅ Card Header --}}
                    <div class="card-header bg-primary text-white fw-bold text-center" style="font-size: 20px;">
                        Role: {{ $mails->admin->authorization?->role ?? '' }}
                    </div>
                    <div class="card-body">

                        {{-- Admin Image --}}
                        <div class="text-center mb-4">
                            <img src="{{ asset($mails->admin->image) }}" alt="Profile Preview" class="shadow border border-2"
                                style="width: 160px; height: 160px; object-fit: cover; border-radius: 50%;">
                        </div>

                        <div class="form">

                            {{-- Name & Email --}}
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" id="name" name="name" value="{{ $mails->admin->name }}"
                                        class="form-control" readonly>
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" id="email" name="email" value="{{ $mails->admin->email }}"
                                        class="form-control" readonly>
                                </div>
                            </div>


                            {{-- Title (Message) --}}
                            <div class="row mb-4">
                                <div class="col-12">
                                    <label for="title" class="form-label">Message</label>
                                    <textarea id="title" name="title" rows="6" class="form-control" readonly>{{ $mails->title }}</textarea>
                                </div>
                            </div>

                            {{-- Buttons --}}
                            <div class="row">
                                <div class="col-md-12 text-center">

                                    {{-- Reply --}}
                                    @if ($mails->admin->role_id != Auth::guard('admin')->user()->role_id)
                                        <a href="mailto:{{ $mails->admin->email }}?subject=Re: {{ $mails->title }}"
                                            class="btn btn-primary px-4 me-3">
                                            <i class="fa fa-reply"></i> Reply
                                        </a>
                                    @endif

                                    {{-- Delete --}}
                                    <a href="#" class="btn btn-danger px-4 delete-contact-btn"
                                        data-id="{{ $mails->id }}">
                                        <i class="fa fa-trash"></i> Delete Contact
                                    </a>

                                    <form action="{{ route('admin.mails.destroy', $mails->id) }}" method="POST"
                                        id="deleteForm_{{ $mails->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                </div>
                            </div>

                        </div> {{-- End Form --}}
                    </div> {{-- End Card Body --}}
                </div> {{-- End Card --}}
            </div>
        </div>
    </div>
@endsection

{{-- SweetAlert --}}
@push('js')
    <script>
        $(document).on('click', '.delete-contact-btn', function(e) {
            e.preventDefault();
            const contactId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This contact will be deleted permanently.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleteForm_' + contactId).submit();
                }
            });
        });
    </script>
@endpush
