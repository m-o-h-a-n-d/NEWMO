<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    <form method="POST" action="{{ route('admin.search.redirect') }}" class="form-inline">
        @csrf
        <input type="text" name="q" class="form-control mr-2" placeholder="search..." autocomplete="off" required>


        <select name="table" class="form-control mr-2" required>
            @can('posts')
                <option value="posts">Posts</option>
            @endcan
            @can('users')
                <option value="users">Users</option>
            @endcan
            @can('categories')
                <option value="categories">Categories</option>
            @endcan
            @can('contacts')
                <option value="contacts">Contacts </option>
            @endcan
            @can('admins')
                <option value="admins">Admins</option>
            @endcan
        </select>

        <button class="btn btn-primary">Search</button>
    </form>




    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Nav Item - Alerts -->
        @can('contacts')

            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i>
                    <!-- Counter - Alerts -->
                    <span class="badge badge-danger badge-counter" id="unread_notifications">
                        {{ Auth::guard('admin')->user()->unreadNotifications->where('data.notification_type', 'notification')->count() ?? 0 }}
                    </span>

                </a>
                <!-- Dropdown - Alerts -->
                <div id="notify_contact" class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="alertsDropdown">

                    @forelse (Auth::guard('admin')->user()->unreadNotifications->where('data.notification_type', 'notification')->sortByDesc('created_at')->take(5) as $notify)
                        <a class="dropdown-item d-flex align-items-center"
                            href="{{ $notify->data['link'] }}?notify_admin={{ $notify->id }}">
                            <div class="mr-3">
                                <div class="icon-circle bg-primary">
                                    <i class="fas fa-file-alt text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">{{ $notify->data['contact_time'] }}</div>
                                <span class="font-weight-bold">{{ $notify->data['contact_title'] }}</span>
                            </div>
                        </a>

                    @empty
                        <div class="col-12 text-center my-4">
                            <div class="alert alert-warning text-center p-4 rounded shadow-sm mb-0" role="alert">
                                <h4 class="alert-heading mb-2">No Notification Available</h4>
                                <p class="mb-0">We couldn't find any Notification at the moment</p>
                            </div>
                        </div>
                    @endforelse
                    <a class="dropdown-item text-center small text-gray-500"
                        href="{{ route('admin.notifications.index') }}">Show All Alerts</a>
                </div>
            </li>
        @endcan
        {{-- ============================================================================================================================ --}}
        {{-- Mail --}}
        <!-- Nav Item - Messages -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>

                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter" id="mail_counter">
                    {{ Auth::guard('admin')->user()->unreadNotifications->where('data.notification_type', 'mail')->count() ?? 0 }}
                </span>

            </a>

            <!-- Dropdown - Messages -->
            <div id="AdminContact" class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="messagesDropdown" style="min-width: 380px; border-radius: 10px;">

                @forelse (Auth::guard('admin')->user()->unreadNotifications->where('data.notification_type', 'mail')->sortByDesc('created_at')->take(5) as $notification)
                    <a href="{{ $notification->data['url'] }}?admins_con={{ $notification->id }}"
                        class="dropdown-item d-flex align-items-start p-3 border-bottom">
                        <div>
                            <img src="{{ asset($notification->data['sender_img'] ?? 'default.png') }}"
                                class="rounded-circle shadow-sm" style="width: 55px; height: 55px; object-fit: cover;"
                                alt="Sender Image">
                        </div>
                        <div class="ml-3" style="flex: 1;">
                            <div class="font-weight-bold text-dark mb-1" style="font-size: 16px;">
                                {{ Str::limit($notification->data['sender_name'],25) ?? 'No Title' }}
                            </div>
                            <div class="small text-muted mb-1">
                                {{ $notification->data['sender_name'] ?? 'Unknown' }} ·
                                {{ $notification->created_at->diffForHumans() }}
                            </div>
                            <div class="small text-secondary">
                                {{ $notification->data['sender_email'] ?? 'No Email' }} |
                                Role: {{ $notification->data['sender_role'] ?? 'N/A' }}
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="p-4 text-center">
                        <div class="alert alert-warning mb-0">
                            <h5 class="mb-2">No Emails Available</h5>
                            <p class="mb-0">We couldn't find any Emails at the moment</p>
                        </div>
                    </div>
                @endforelse

                <a href="{{ route('admin.mails.index') }}"
                    class="dropdown-item text-center text-primary font-weight-bold py-2"
                    style="border-top: 1px solid #ddd;">
                    Show More Mails
                </a>
            </div>

        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span
                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::guard('admin')->user()->name }}</span>
                <img class="rounded-circle" src="{{ asset(Auth::guard('admin')->user()->image) }}"
                    style="width: 60px; height: 60px; border-radius: 50%;" alt="...">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item"
                    href="{{ route('admin.profile.profile', Auth::guard('admin')->user()->id) }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="{{ route('admin.profile.index') }}">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>

            </div>
        </li>

    </ul>

</nav>
