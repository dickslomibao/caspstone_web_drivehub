<div class="card-header">
    <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
            <a class="nav-link{{ request()->is('admin/schoolDetails/*') ? ' active' : '' }}" href="{{ route('admin.schools.details', $school_id)}}">
                <i class="fa-solid fa-circle-user"></i> Statistics
            </a>
        </li>

        {{-- <li class="nav-item">
            <a class="nav-link{{ request()->is('admin/schoolCourses/*') ? ' active' : '' }}" href="{{ route('admin.schools.courses', $school_id)}}">
                <i class="fa-solid fa-star"></i> Courses
            </a>
        </li> --}}

        {{-- <li class="nav-item">
            <a class="nav-link{{ request()->is('admin/schoolStudents/*') ? ' active' : '' }}" href="{{ route('admin.schools.students', $school_id) }}">
                <i class="fa-solid fa-calendar-days"></i> Students
            </a>
        </li> --}}

        <li class="nav-item">
            <a class="nav-link{{ request()->is('admin/school/reports/*') ? ' active' : '' }}" href="{{ route('admin.school.reports', $school_id) }}">
                <i class="fa-solid fa-calendar-days"></i> Reports
            </a>
        </li>
{{-- 
        <li class="nav-item">
            <a class="nav-link{{ request()->is('admin/school/reviews/*') ? ' active' : '' }}" href="{{ route('admin.school.reviews', $school_id) }}">
                <i class="fa-solid fa-calendar-days"></i> Reviews
            </a>
        </li> --}}


    </ul>
</div>