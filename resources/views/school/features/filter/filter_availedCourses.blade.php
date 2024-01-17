<script>
    $(document).ready(function() {
        $('#table1').DataTable();
    });
</script>



<div class="w-100 d-flex justify-content-between table-header-btn">
    <div class="d-flex" style="gap:15px">
        <a class="btn-outline-light" href="/school/availedCourses/{{$status}}/{{$start_date}}/{{$end_date}}/export_pdf"><i class="fa-solid fa-file-export"></i>Export
            PDF</a>
    </div>
</div>

<table id="table1" class="table1" style="width:100%">
    <thead>
        <tr>
            <th>Student name</th>
            <th>Type</th>
            <th>Course</th>
            <th>Duration</th>
            <th>Remarks</th>
            <th width="120">Status</th>
            <th>Date Created</th>
            <th width="50">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ( $students as $student)
        @php
        $statusClass = '';

        if ($student->status == 1) {
        $status = 'Waiting';
        $statusClass = 'waiting';
        } elseif ($student->status == 2) {
        $status = 'Ongoing';
        $statusClass = 'started';
        } else {
        $status = 'Completed';
        $statusClass = 'completed';
        }
        @endphp
        <tr>
            <td>

                <div class="d-flex align-items-center" style="gap: 10px;padding:5px 0">
                    <img src="/{{ $student-> profile_image}}" class="rounded-circle" style="width: 40px;height:40px" alt="Avatar" />
                    <div>
                        <h6>{{ $student-> firstname}} {{$student->middlename ?? ""}} {{ $student->lastname}}</h6>
                        <p style="font-size:14px" class="email">{{ $student->email}}</p>
                    </div>
                </div>

            </td>
            <td>{{ $student->type == 1 ? 'Practical' : 'Theoretical' }}</td>
            <td>{{$student -> name}}</td>
            <td>{{$student -> duration}} hrs <br> {{$student -> session}} session</td>
            <td>{{$student -> remarks}}</td>
            <td><span class="{{ $statusClass }}">{{ $status }}</span></td>
            <td>{{ \Carbon\Carbon::parse($student->date_created)->format('F j, Y | h:i:s A') }}</td>
            <td>
                <div class="dropdown">
                    <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    </i>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/availed/courses/{{$student->id}}/view">View</a></li>
                        <li><a class="dropdown-item update" role="button">Update</a></li>
                        <li><a class="dropdown-item" href="#">Delete</a></li>
                    </ul>
                </div>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>