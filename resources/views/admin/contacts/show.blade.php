@extends('layouts.backend.app')
{{-- Title Of Page  --}}
@section('admin_title')
    Show Contacts
@endsection

{{-- Body of the Page  --}}
@section('body')
    <div class="container">
        <div class="row justify-content-center">
            <h2 class="text-center  w-100" style="font-size: 40px">Show User</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mb-5 shadow">
                    <div class="card-body ">
                        {{-- Optional image preview (below upload box) --}}

                        <div class="form">

                            {{-- name & username & email --}}
                            <div class="row mb-3">
                                {{-- Full  Name --}}
                                <div class="col-md-4">
                                    <label for="name" class="col-form-label text-md-end">{{ __('Full Name') }}</label>
                                    <span style="color: red !important; display: inline; float: none;">*</span>
                                    <input id="name" type="text" class="form-control " name="name"
                                        value="{{ $contact->name }}" readonly autocomplete="name" autofocus>


                                </div>

                                {{-- Email  --}}
                                <div class="col-md-4">
                                    <label for="email"
                                        class=" col-form-label text-md-end">{{ __('Email Address') }}</label>
                                    <span style="color: red !important; display: inline; float: none;">*</span>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ $contact->email }}" readonly required autocomplete="email">
                                </div>
                                {{-- Phone  --}}

                                <div class="col-md-4">
                                    <label for="phone" class=" col-form-label text-md-end">{{ __('Phone') }}</label>
                                    <span style="color: red !important; display: inline; float: none;">*</span>
                                    <input id="phone" type="text"
                                        class="form-control @error('phone') is-invalid @enderror" name="phone"
                                        value="{{ $contact->phone }}" readonly required autocomplete="phone">
                                </div>
                            </div>

                            {{-- ======================================================== --}}

                            {{-- Title &Body  --}}
                            <div class="col-md-12">
                                <label for="title" class=" col-form-label text-md-end">{{ __('title') }}</label>
                                <span style="color: red !important; display: inline; float: none;">*</span>
                                <textarea id="title" type="text" cols="30" rows="3"
                                    class="form-control @error('title') is-invalid @enderror" name="title" readonly required autocomplete="title">{{ $contact->title }}</textarea>
                            </div>

                            <div class="col-md-12">
                                <label for="body" class=" col-form-label text-md-end">{{ __('body') }}</label>
                                <span style="color: red !important; display: inline; float: none;">*</span>
                                <textarea id="body" type="text" class="form-control @error('body') is-invalid @enderror" name="body"
                                    cols="30" rows="5" readonly required autocomplete="body">{{ $contact->body }}</textarea>
                            </div>



                            {{-- ======================================================== --}}


                            {{-- Button --}}
                            <div class="row  ">
                                <div class=" col-md-9 offset-md-4 p-4">



                                    <a href="mailto:{{ $contact->email }}?subject=Re::{{ $contact->title }} "
                                        class="btn btn-primary p-2 border-redis-3" target="_blank"><i
                                            class="fa fa-reply"></i> Replay</a>

                                    {{-- Delete --}}
                                    <a href="{{ route('admin.contacts.destroy', $contact->id) }}"
                                        class="btn btn-danger p-2 border-redis-3 delete-contact-btn"
                                        data-id="{{ $contact->id }}">
                                        {{ __('Delete contact') }}
                                    </a>
                                    <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST"
                                        id="deleteForm_{{ $contact->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>



                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



{{-- Sweet alart --}}
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
