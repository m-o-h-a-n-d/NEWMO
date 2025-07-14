<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name') }} | @yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <meta content="@yield('small_desc')" name="description" />



    <!-- Favicon -->
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset($Settings->favicon) }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset($Settings->favicon) }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset($Settings->favicon) }}">
    <link rel="shortcut icon" href="{{ asset($Settings->favicon) }}">


    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600&display=swap" rel="stylesheet" />

    <!-- CSS Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="{{ asset('assets/lib/slick/slick.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/lib/slick/slick-theme.css') }}" rel="stylesheet" />
    {{-- summer Note --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/summernote/summernote-bs4.css') }}">

    {{-- File input --}}
    <link rel="stylesheet" href="{{ asset('assets/vendor/file-input/css/fileinput.min.css') }}">


    @stack('css')

    <!-- Template Style sheet -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />

</head>

<body>

    {{-- start header --}}
    @include('layouts.frontend.header')
    {{-- End header --}}
    {{-- Start Notification Broadcast Client side js  --}}
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    @auth
        <script>
            const role = 'user';
            const userId = "{{ auth()->user()->id }}";
        </script>
        <script src="{{ asset('build/assets/app-BMOoW2fL.js') }}"></script>


    @endauth

    {{-- End Notification Broadcast Client side js  --}}

    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container">
            <ul class="breadcrumb">
                @section('breadcrumb')
                    <li class="breadcrumb-item "><a href="{{ route('frontend.home') }}">Home</a></li>
                @show
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    {{-- Start Body of the website --}}
    @yield('content')
    {{-- End Body of the website --}}


    {{-- start footer --}}
    @include('layouts.frontend.footer')
    {{-- End footer --}}

    <!-- Back to Top -->
    <a href="{{ route('frontend.home') }}" class="back-to-top"><i class="fa fa-chevron-up"></i></a>






    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('assets/lib/slick/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>


    <!-- Toastr JS and CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- Sweet alar --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- File Input --}}
    <script src="{{ asset('assets/vendor/file-input/js/fileinput.min.js') }}"></script>

    {{-- Summer Note  --}}
    <script src="{{ asset('assets/vendor/summernote/summernote-bs4.js') }}"></script>

    {{-- Ajax --}}
    @stack('js')





</body>

</html>
