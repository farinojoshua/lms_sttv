<!-- Top Bar Start -->
<div class="topbar">
    <div class="topbar-left">
        <a href="{{ route('dashboard') }}" class="logo">
            <span class="logo-light">
                <i class="mdi mdi-camera-control"></i> STT Victory
            </span>
            <span class="logo-sm">
                <i class="mdi mdi-camera-control"></i>
            </span>
        </a>
    </div>
    <nav class="navbar-custom">
        <ul class="navbar-right list-inline float-right mb-0">
            <!-- full screen -->
            <li class="dropdown notification-list list-inline-item d-none d-md-inline-block">
                <a class="nav-link waves-effect" href="#" id="btn-fullscreen">
                    <i class="mdi mdi-arrow-expand-all noti-icon"></i>
                </a>
            </li>
            <!-- profile -->
            <li class="dropdown notification-list list-inline-item">
                <div class="dropdown notification-list nav-pro-img">
                    <a class="dropdown-toggle nav-link arrow-none nav-user" data-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="{{ $authUser->profile_photo_path ? asset('storage/' . $authUser->profile_photo_path) : asset('assets/images/users/user-4.jpg') }}"
                            alt="user" class="rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <!-- item-->
                        <a class="dropdown-item" href="{{ route('profile.edit') }}"><i
                                class="mdi mdi-account-circle"></i> Profile</a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="mdi mdi-power text-danger"></i> Logout
                            </a>
                        </form>
                    </div>
                </div>
            </li>
        </ul>
        <ul class="list-inline menu-left mb-0">
            <li class="float-left">
                <button class="button-menu-mobile open-left waves-effect">
                    <i class="mdi mdi-menu"></i>
                </button>
            </li>
        </ul>
    </nav>
</div>
<!-- Top Bar End -->
