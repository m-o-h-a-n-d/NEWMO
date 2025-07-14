    <!-- Top Bar Start -->
    <div class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="tb-contact">
                        <p>
                            <a href="mailto:{{ $Settings->email }}" style="color:inherit; ">
                                <i class="fa fa-envelope"></i>
                                {{ $Settings->email }}
                            </a>
                        </p>
                        <p>
                            <a href="tel:{{ $Settings->phone }} " style="color: inherit;">
                                <i class="fa fa-phone"></i>
                                {{ $Settings->phone }}
                            </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="tb-menu">
                       
                        <a href="{{ route('frontend.contact.index') }}">Contact</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Top Bar Start -->

    <!-- Brand Start -->
    <div class="brand">
        <div class="container ">
            <div class="row align-items-center d-flex justify-content-between ">
                <div class="col-md-3 col-md-4">
                    <div class="b-logo">
                        <a href="{{ route('frontend.home') }}">
                            <img src="{{ asset($Settings->logo) }}" alt="Logo" width="120">


                        </a>
                    </div>
                </div>

                <div class="col-md-5 col-md-4">
                    <div class="b-search">
                        <form action="{{ route('frontend.search') }}" method="Post">
                            @csrf
                            <input type="text" name="search" id="search" placeholder="Search" />
                            <button type="submit" id="search-btn"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                </div>
                {{-- Authantecation  --}}
                {{-- For Large Screens (Visible on ≥ lg) --}}
                <div class="col-md-2 d-none d-md-block">
                    {{-- Auth Login And Register --}}
                    @guest
                        <div class="nav-item dropdown">
                            <a class="nav-link p-0 pr-3" data-toggle="dropdown" href="#">
                                <img src="{{ asset('assets/img/avatar5.png') }}"
                                    class='img-circle  rounded-circle elevation-2' width="40" height="40"
                                    alt="user image">
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-3">
                                <a href="{{ route('login') }}" class="dropdown-item">
                                    <i class="fas fa-user mr-2"></i> Login
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('register') }}" class="dropdown-item">
                                    <i class="fas fa-user mr-2"></i> Register
                                </a>
                            </div>
                        </div>
                    @endguest
                    {{-- Auth in large and midium screen  --}}
                    @auth
                        <div class="nav-item dropdown">
                            <a class="nav-link p-0 pr-3" data-toggle="dropdown" href="#">
                                <img src="{{ Auth::user()->image_url }}" class='img-circle  rounded-circle elevation-2'
                                    width="50" height="50" alt="">
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-3">
                                <h4 class="h4 mb-0"><strong>{{ Auth::user()->username }}</strong></h4>
                                <div class="mb-3">{{ Auth::user()->email }}</div>
                                <a href="{{ route('frontend.dashboard.profile') }}" class="dropdown-item">
                                    <i class="fas fa-user mr-2"></i> Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('frontend.dashboard.setting') }}" class="dropdown-item">
                                    <i class="fas fa-user-cog mr-2"></i> Settings
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item text-danger" id="logoutBtn">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </a>
                            </div>
                        </div>



                    @endauth

                </div>
            </div>
        </div>
    </div>
    <!-- Brand End -->

    <!-- Nav Bar Start -->
    <div class="nav-bar">
        <div class="container">
            @include('layouts.frontend.navbar')
        </div>
    </div>
    <!-- Nav Bar End -->

    {{-- Sweet alart --}}
    @push('js')
        <script>
            $('#logoutBtn').click(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure you want to logout?',
                    text: "You will be logged out of your account.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#FormCont').submit();
                    }
                });
            });
        </script>
    @endpush
