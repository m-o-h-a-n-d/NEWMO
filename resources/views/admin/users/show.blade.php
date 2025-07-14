@extends('layouts.backend.app')
{{-- Title Of Page  --}}
@section('admin_title')
    Create Users
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
                        <div class=" mt-3  text-center">
                            <img src="{{ asset($user->image) }}" alt="Profile Preview" class="shadow-lg border border-2"
                                style="width: 160px; height: 160px; object-fit: cover; border-radius: 50%;">

                            <br>
                        </div>
                        <div class="form">

                            {{-- name & username & email --}}
                            <div class="row mb-3">
                                {{-- Full  Name --}}
                                <div class="col-md-4">
                                    <label for="name" class="col-form-label text-md-end">{{ __('Full Name') }}</label>
                                    <span style="color: red !important; display: inline; float: none;">*</span>
                                    <input id="name" type="text" class="form-control " name="name"
                                        value="{{ $user->name }}" readonly required autocomplete="name" autofocus>


                                </div>
                                {{--  User Name --}}
                                <div class="col-md-4">
                                    <label for="username"class="col-form-label text-md-end">{{ __('username') }}</label>
                                    <span style="color: red !important; display: inline; float: none;">*</span>
                                    <input id="username" type="text" class="form-control " name="username"
                                        value="{{ $user->username }}" readonly required autocomplete="name" autofocus>


                                </div>
                                {{-- Email  --}}
                                <div class="col-md-4">
                                    <label for="email"
                                        class=" col-form-label text-md-end">{{ __('Email Address') }}</label>
                                    <span style="color: red !important; display: inline; float: none;">*</span>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ $user->email }}" readonly required autocomplete="email">


                                </div>
                            </div>

                            {{-- ======================================================== --}}

                            {{-- Country Lists & status &email_status  --}}
                            <div class="row mb-3">
                                {{-- Country --}}
                                <div class="col-md-4">
                                    <label for="country">Country</label>
                                    <span style="color: red !important; display: inline; float: none;">*</span>
                                    <input type="text" value="{{ $user->country }}" name="country" class="form-control"
                                        readonly required>
                                </div>
                                {{-- status --}}
                                <div class="col-md-4">
                                    <label for="status">Status</label>
                                    <span style="color: red !important; display: inline; float: none;">*</span>
                                    <input disabled value="{{ $user->status == 0 ? 'Not Available' : 'Active' }}"
                                        name="status" class="form-control" readonly required>
                                </div>
                                {{-- email Status --}}
                                <div class="col-md-4">
                                    <label for="email_verified_at">email_verified_at</label>
                                    <span style="color: red !important; display: inline; float: none;">*</span>
                                    <input disabled
                                        value="{{ $user->email_verified_at == null ? 'Not Available' : 'Active' }}"
                                        name="email_verified_at" class="form-control" readonly required>
                                </div>
                            </div>
                            {{-- ======================================================== --}}

                            {{-- City & street & Phone  --}}
                            <div class="row mb-3">

                                {{-- City  --}}
                                <div class="col-md-4">

                                    <label for="city"class="col-form-label text-md-end">{{ __('city') }}</label>
                                    <span style="color: red !important; display: inline; float: none;">*</span>

                                    <input id="city" type="text" class="form-control" name="city"
                                        value="{{ $user->city }}" readonly required autocomplete="city" autofocus>


                                </div>
                                {{-- Street --}}
                                <div class="col-md-4">
                                    <label for="street" class=" col-form-label text-md-end">{{ __('Street ') }}</label>
                                    <span style="color: red !important; display: inline; float: none;">*</span>
                                    <input id="street" type="text" class="form-control " name="street"
                                        value="{{ $user->street }}" readonly required autocomplete="street">


                                </div>
                                {{-- phone --}}
                                <div class="col-md-4">
                                    <label for="phone" class="col-form-label text-md-end">{{ __('Phone') }}</label>
                                    <span style="color: red !important; display: inline; float: none;">*</span>
                                    <input id="phone" type="text" class="form-control " name="phone"
                                        value="{{ $user->phone }}" readonly required autocomplete="phone" autofocus>


                                </div>
                            </div>

                            {{-- ======================================================== --}}


                            {{-- Button --}}
                            <div class="row  ">
                                <div class="col-md-9 offset-md-4 p-4">
                                    {{-- Block Or UnBlock --}}
                                    @if ($user->status == 0)
                                        <a href="{{ route('admin.users.BlockUser', $user->id) }}"
                                            class="btn btn-primary p-2 border-redis-3">

                                            {{ __('Active User') }}
                                        </a>
                                    @else
                                        <a href="{{ route('admin.users.BlockUser', $user->id) }}"
                                            class="btn btn-primary p-2 border-redis-3" >
                                            {{ __('Not Active') }}
                                        </a>
                                    @endif
                                    {{-- Delete --}}
                                    <a href="{{ route('admin.users.destroy', $user->id) }}"
                                        class="btn btn-danger p-2 border-redis-3 delete-user-btn"
                                        data-id="{{ $user->id }}">
                                        {{ __('Delete User') }}
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                        id="deleteForm_{{ $user->id }}">
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
        $(document).on('click', '.delete-user-btn', function(e) {
            e.preventDefault();
            const userId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This user will be deleted permanently.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleteForm_' + userId).submit();
                }
            });
        });
    </script>
@endpush
