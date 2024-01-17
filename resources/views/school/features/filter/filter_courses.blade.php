<script>
    $(document).ready(function() {
        $('#table1').DataTable();
    });
</script>



<div class="w-100 d-flex justify-content-between table-header-btn">
    <div class="d-flex" style="gap:15px">
        <a class="btn-outline-light" href="/school/courses/{{$status}}/{{$start_date}}/{{$end_date}}/export_pdf"><i class="fa-solid fa-file-export"></i>Export
            PDF</a>
    </div>
    <a href="{{ route('create.course') }}">
        <button class="btn-add-management"><i class="fa-solid fa-plus"></i> Add new
            Course</button>
    </a>

</div>

<table id="table1" class="table1" style="width:100%">
    <thead>
        <tr>
            <th>Name</th>
            <th width="120">Status</th>
            <th width="200">Date Created</th>
            <th width="50">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ( $courses as $course)

        @php
        $statusClass = '';

        if ($course->status == 1) {
        $status = '&#8226 Available';
        $statusClass = 'available';
        } else if ($course->status == 2) {
        $status = '&#8226 Not Available';
        $statusClass = 'not-available';
        }
        @endphp

        <tr>
            <td>

                {{$course->name}}
            </td>
            <td><span class="{{ $statusClass }}">{!! $status !!}</span></td>
            <td>{{ \Carbon\Carbon::parse($course->date_created)->format('F j, Y - h:i:s A') }}</td>
            <td>
                <div class="dropdown">
                    <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    </i>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/school/courses/{{$course->id}}/view">View course</a></li>
                        <li><a class="dropdown-item update" href="/school/courses/{{$course->id}}/updateView">Update</a>
                        </li>
                        <li><a class="dropdown-item delete" href="#">Delete</a></li>
                    </ul>
                </div>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>