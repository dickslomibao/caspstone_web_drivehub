<div class="card-header">
    <ul class="nav nav-tabs card-header-tabs">
        <li class="nav-item">
            <a class="nav-link{{ request()->is('admin/pendingSchoolDetails/*') ? ' active' : '' }}" href="{{ route('admin.pending.schools.details', $school_id)}}">
              Mayor's Permit
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link{{ request()->is('admin/pendingDTI/*') ? ' active' : '' }}" href="{{ route('admin.pending.schools.DTI', $school_id)}}">
             DTI Permit
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link{{ request()->is('admin/pendingLTO/*') ? ' active' : '' }}" href="{{ route('admin.pending.schools.LTO', $school_id)}}">
               LTO Accreditation  Certificate
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link{{ request()->is('admin/pendingOwner/*') ? ' active' : '' }}" href="{{ route('admin.pending.schools.Owner', $school_id) }}">
               Owner's 2x2 Picture & Valid ID
            </a>
        </li>

    </ul>
</div>