<div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu" id="side-menu">
                <li class="menu-title">Menu</li>
                <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                        <i class="icon-accelerator"></i><span> Dashboard </span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.courses.index') }}" class="waves-effect"><i
                            class="icon-paper-sheet"></i><span> Mata Kuliah </span></a>
                </li>
                <li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.users.index') }}" class="waves-effect"><i class="icon-case"></i><span>
                            Pengguna </span></a>
                </li>
                <!-- Other sidebar items -->
            </ul>
        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
