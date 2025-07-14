<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    @can('home')
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.home') }}">

            <div class="b-logo">
                <img src="{{ asset('assets/img/admin.png') }}" width="100%" alt="Logo" />
            </div>
        </a>
    @endcan
    @cannot('home')
        <div class="sidebar-brand d-flex align-items-center justify-content-center">

            <div class="b-logo">
                <img src="{{ asset('assets/img/admin.png') }}" width="100%" alt="Logo" />
            </div>
        </div>
    @endcannot

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    @can('home')
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('admin.home') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
    @endcan

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Control Panel
    </div>
    @can('users')
        <!-- Nav Item - User -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-users"></i>
                <span>User Management</span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('admin.users.index') }}">Users</a>
                    <a class="collapse-item" href="{{ route('admin.users.create') }}">Add Users</a>

                </div>
            </div>
        </li>
    @endcan
    {{-- Admin --}}
    @can('admins')
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#AdminMails"
                aria-expanded="true" aria-controls="AdminMails">
                <i class="fas fa-fw fa-user"></i>
                <span>Admin Management</span>
            </a>
            <div id="AdminMails" class="collapse" aria-labelledby="headingPages" data-parent="#AdminMails">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('admin.admins.index') }}">Admins</a>
                    <a class="collapse-item" href="{{ route('admin.admins.create') }}">Add Admin</a>


                </div>
            </div>
        </li>
    @endcan
    {{-- Authorization --}}
    @can('authorizations')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.authorize.index') }}">
                <i class="fas fa-fw fa-user-shield"></i>
                <span>Authorization</span></a>
        </li>
    @endcan

    {{-- Notifications --}}
    @can('contacts')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.notifications.index') }}">
                <i class="fas fa-fw fa-bell"></i>
                <span>Notifications</span></a>
        </li>
    @endcan


    <!-- Nav Item - contacts -->
    @can('contacts')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.contacts.index') }}">
                <i class="fas fa-fw fa-phone"></i>
                <span>Contacts</span></a>
        </li>
    @endcan

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Addons
    </div>



    @can('posts')
        <!-- Nav Item - Posts  -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-folder"></i>
                <span>Posts Management</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">

                    <a class="collapse-item" href="{{ route('admin.posts.index') }}">Posts</a>
                    <a class="collapse-item" href="{{ route('admin.posts.create') }}">Create Post</a>
                </div>
            </div>
        </li>
    @endcan

    @can('mail')
    <!-- Nav Item - Posts  -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#MailsAdmin"
            aria-expanded="true" aria-controls="MailsAdmin">
            <i class="fas fa-envelope fa-fw"></i>
            <span>Mails Management</span>
        </a>
        <div id="MailsAdmin" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                    <a class="collapse-item" href="{{ route('admin.mails.index') }}">Mails</a>
                    <a class="collapse-item" href="{{ route('admin.mails.create') }}">Create Mails</a>

            </div>
        </div>
    </li>
    @endcan





    <!-- Nav Item - Categories -->
    @can('categories')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.categories.index') }}">
                <i class="fas fa-fw fa-table"></i>
                <span>Categories</span></a>
        </li>
    @endcan





    @can('settings')
        <!-- Nav Item - Utilities Sittings Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Setting</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">setting:</h6>
                    <a class="collapse-item" href="{{ route('admin.settings.index') }}">Setting</a>

                </div>
            </div>
        </li>
    @endcan



    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>




</ul>
<!-- End of Sidebar -->
