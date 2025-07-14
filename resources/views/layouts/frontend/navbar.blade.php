<nav class="navbar navbar-expand-md bg-dark navbar-dark">

    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    {{-- Auth --}}
    <div class="navbar-brand">
        {{-- Auth Login And Register --}}
        @guest
            <div class="nav-item dropdown">
                <a class="nav-link p-0 pr-3" data-toggle="dropdown" href="#">
                    <img src="{{ asset('assets/img/avatar5.png') }}" class='img-circle  rounded-circle elevation-2'
                        width="40" height="40" alt="">
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

        {{-- Auth Logout --}}

        @auth
            <div class="nav-item dropdown">
                <a class="nav-link p-0 pr-3" data-toggle="dropdown" href="#">
                    <img src="{{ Auth::user()->image_url }}" class='img-circle  rounded-circle elevation-2' width="40"
                        height="40" alt="">
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-3">
                    <h4 class="h4 mb-0"><strong>{{ Auth::user()->username }}</strong></h4>
                    <div class="mb-3">{{ Auth::user()->email }}</div>
                    <div class="dropdown-divider"></div>
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

        <form action="{{ route('logout') }}" id="FormCont" method="Post" style="display: none;">
            @csrf
        </form>
    </div>
    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
        {{-- Home --}}
        <div class="navbar-nav mr-auto">
            <a href="{{ route('frontend.home') }}"
                class="nav-item nav-link {{ Route::is('frontend.home') ? 'active' : '' }}">
                Home
            </a>
            <div class="nav-item dropdown {{ Route::is('frontend.category.posts*') ? 'active' : '' }}">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Category</a>
                <div class="dropdown-menu">
                    @foreach ($categories as $category)
                        <a href="{{ route('frontend.category.posts', $category->slug) }}"
                            class="dropdown-item {{ request()->is('category/' . $category->slug) ? 'active' : '' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>




            <a href="{{ route('frontend.contact.index') }}"
                class="nav-item nav-link {{ Route::is('frontend.contact.index') ? 'active' : '' }}">
                Contact Us
            </a>

            <a href="{{ route('frontend.dashboard.profile') }}"
                class="nav-item nav-link {{ Route::is('frontend.dashboard.profile') ? 'active' : '' }}">
                Profile
            </a>


        </div>
        <div class="social ml-auto">
            <a href="{{ $Settings->twitter }}">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="{{ $Settings->facebook }}"><i class="fab fa-facebook-f"></i></a>
            <a href="{{ $Settings->linkedin }}"><i class="fab fa-linkedin-in"></i></a>
            <a href="{{ $Settings->instagram }}"><i class="fab fa-instagram"></i></a>
            <a href="{{ $Settings->youtube }}"><i class="fab fa-youtube"></i></a>
            <a href="{{ $Settings->whatsapp }}"><i class="fab fa-whatsapp"></i></a>

            {{-- Notification --}}
            <!-- Notification Dropdown -->
            @auth
                <span class="notification-count" id="cont-notification">
                    {{ auth()->user()->unreadNotifications->count() }}
                </span>

                <a href="#" class="nav-link position-relative" id="notificationDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-lg"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right shadow-lg border-0" aria-labelledby="notificationDropdown"
                    style="width: 300px; max-height: 300px ; overflow-y: auto;">
                    <div class="d-flex  justify-content-between align-items-center p-2 border-bottom">
                        <a href="{{ route('frontend.dashboard.notification') }}"
                            class="dropdown-header text-primary bg-white">Notifications</a>
                        <form action="{{ route('frontend.dashboard.notification.mark') }}" style="width: 80px ; ">
                            <button class="btn btn-sm btn-danger w-100" type="submit">Mark All</button>
                        </form>
                    </div>


                    <div id="push-notification">
                        @forelse (auth()->user()->unreadNotifications as $notify)
                            <div style="padding-bottom: 20px; margin: 40px 0; ">
                                <a href="{{ $notify->data['url'] ?? '#' }}?notify={{ $notify->id }}"
                                    class="dropdown-item d-flex align-items-start"
                                    style="text-decoration: none; background-color:white; gap: 15px;  ">

                                    <img src="{{ $notify->data['commenter_image'] ?? '/default-user.png' }}"
                                        class="rounded-circle" width="50" height="50"
                                        style="object-fit: cover; flex-shrink: 0;" alt="User Image" />

                                    <div class="flex-grow-1">
                                        <strong class="d-block mb-1">
                                            {{ $notify->data['commenter_name'] ?? 'Unknown User' }}
                                        </strong>
                                        <div class="small text-muted mb-1">
                                            علق على: <strong>{{ $notify->data['post_title'] }}</strong>
                                        </div>
                                        <div class="text-dark" style="font-size: 14px;">
                                            {{ Str::limit($notify->data['comment'] ?? '', 15) }}
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="col-12 text-center my-4">
                                <div class="alert alert-warning text-center p-4 rounded shadow-sm mb-0" role="alert">
                                    <h4 class="alert-heading mb-2">No Notification Available</h4>
                                    <p class="mb-0">We couldn't find any Notification at the moment</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                </div>
            @endauth






            {{-- End Notification --}}
        </div>
    </div>
</nav>
