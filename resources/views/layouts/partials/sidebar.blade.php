<div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu" id="side-menu">
                <li class="menu-title">Menu</li>
                @php
                    $role = Auth::user()->role;
                @endphp

                <li class="{{ request()->routeIs('dashboard') || request()->routeIs("{$role}.dashboard") ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="icon-accelerator"></i><span> Dashboard </span>
                    </a>
                </li>

                @if ($role == 'admin')
                    <li class="{{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.courses.index') }}" class="waves-effect">
                            <i class="icon-paper-sheet"></i><span> Courses </span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.users.index') }}" class="waves-effect">
                            <i class="icon-people"></i><span> Users </span>
                        </a>
                    </li>
                @elseif ($role == 'lecturer')
                    @php
                        $lecturerCourseActive = request()->routeIs('lecturer.courses.myCourses') || request()->routeIs('lecturer.sections.*');
                    @endphp
                    <li class="{{ request()->routeIs('lecturer.courses.allAvailableCourses') ? 'active' : '' }}">
                        <a href="{{ route('lecturer.courses.allAvailableCourses') }}" class="waves-effect">
                            <i class="icon-paper-sheet"></i><span> All Courses </span>
                        </a>
                    </li>
                    <li class="{{ $lecturerCourseActive ? 'active' : '' }}">
                        <a href="{{ route('lecturer.courses.myCourses') }}" class="waves-effect">
                            <i class="icon-paper-sheet"></i><span> My Courses </span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('lecturer.grades.index') ? 'active' : '' }}">
                        <a href="{{ route('lecturer.grades.index') }}" class="waves-effect">
                            <i class="icon-graduation"></i><span> Grades </span>
                        </a>
                    </li>
                @elseif ($role == 'student')
                    @php
                        $studentCourseActive = request()->routeIs('student.courses.index') || request()->routeIs('student.courses.enrolled') || request()->routeIs('student.sections.*');
                    @endphp
                    <li class="{{ $studentCourseActive ? 'active' : '' }}">
                        <a href="{{ route('student.courses.index') }}" class="waves-effect">
                            <i class="icon-paper-sheet"></i><span> Available Courses </span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('student.courses.enrolled') ? 'active' : '' }}">
                        <a href="{{ route('student.courses.enrolled') }}" class="waves-effect">
                            <i class="icon-paper-sheet"></i><span> Enrolled Courses </span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('student.grades.index') ? 'active' : '' }}">
                        <a href="{{ route('student.grades.index') }}" class="waves-effect">
                            <i class="icon-graduation"></i><span> Grades </span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
