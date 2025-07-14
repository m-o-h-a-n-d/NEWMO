@extends('layouts.frontend.app')


{{--  Breadcrumb start  --}}
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">Contact</li>
@endsection
{{--  Breadcrumb End  --}}


@section('title')
ContactUs
@endsection


@section('content')


    <!-- Breadcrumb End -->
    <div class="contact">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="contact-form">
                        <form action="{{ route('frontend.contact.store') }}" method="post">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <input type="text" name="name" class="form-control" placeholder="Your Name" />
                                    <strong class="text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </strong>
                                </div>

                                <div class="form-group col-md-4">
                                    <input type="text" name="phone" class="form-control" placeholder="Your Phone" />
                                    <strong class="text-danger">
                                        @error('phone')
                                            {{ $message }}
                                        @enderror
                                    </strong>
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="email" name="email" class="form-control" placeholder="Your Email" />
                                    <strong class="text-danger">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </strong>
                                </div>
                            </div>

                            <div class="form-group">

                                <input type="text" name="title" class="form-control" placeholder="Subject" />
                                <strong class="text-danger">
                                    @error('title')
                                        {{ $message }}
                                    @enderror
                                </strong>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="body" rows="5" placeholder="Message"></textarea>
                                <strong class="text-danger">
                                    @error('body')
                                        {{ $message }}
                                    @enderror
                                </strong>
                            </div>
                            <div>
                                <button class="btn" type="submit">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-info">
                        <h3>ContactUs</h3>

                        {{-- Location --}}
                        <h4>
                            <a href="https://www.google.com/maps/search/{{ " $Settings->street $Settings->city  $Settings->country" }}"
                                style="color: inherit;">
                                <i class="fa fa-map-marker"></i>
                                {{ $Settings->street }},{{ $Settings->city }},{{ $Settings->country }}
                            </a>
                        </h4>
                        {{--    MAil  --}}
                        <h4>
                            <a href="mailto:{{ $Settings->email }}" style="color:inherit; ">
                                <i class="fa fa-envelope"></i>
                                {{ $Settings->email }}
                            </a>
                        </h4>
                        {{--    Phone --}}
                        <h4>
                            <a href="tel:{{ $Settings->phone }} " style="color: inherit;">
                                <i class="fa fa-phone"></i>
                                {{ $Settings->phone }}
                            </a>
                        </h4>
                        {{--    Social --}}
                        <div class="social">
                            <a href="{{ $Settings->twitter }}">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="{{ $Settings->facebook }}"><i class="fab fa-facebook-f"></i></a>
                            <a href="{{ $Settings->linkedin }}"><i class="fab fa-linkedin-in"></i></a>
                            <a href="{{ $Settings->instagram }}"><i class="fab fa-instagram"></i></a>
                            <a href="{{ $Settings->youtube }}"><i class="fab fa-youtube"></i></a>
                            <a href="{{ $Settings->whatsapp }}"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection


{{-- Ajax Error --}}
@push('js')
    <script>
        $(document).ready(function() {

            $('input, textarea').on('input', function() {
                const input = $(this);
                const name = input.attr('name');
                const value = input.val().trim();

                let isValid = false;

                switch (name) {
                    case 'name':
                        isValid = value.length >= 2 && value.length <= 50;
                        break;
                    case 'phone':
                        isValid = /^\d+$/.test(value); // فقط أرقام
                        break;
                    case 'email':
                        isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
                        break;
                    case 'title':
                        isValid = value.length > 0 && value.length <= 60;
                        break;
                    case 'body':
                        isValid = value.length >= 8 && value.length <= 500;
                        break;
                }

                if (isValid) {
                    // نحذف رسالة الخطأ الموجودة تحت هذا العنصر
                    input.closest('.form-group').find('.text-danger').text('');
                }
            });
        });
    </script>
@endpush
