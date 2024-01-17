<script>
$(document).ready(function() {
    $('#table3').DataTable();
});
</script>


<table id="table3" class="table" style="width:100%">

    <thead>
        <tr>
            <th></th>
            <th>Driving School</th>
            <th>Address</th>
            <th>Date Joined</th>

            <th>No. of Students</th>
            <th>No. of Instructors</th>
            <th>No. of Booked Courses</th>
            <th>Completion Rate</th>
            <th style="width: 60px">Action</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($schools as $school)



        @php
        $statusClass = '';

        if ($school -> accreditation_status == 2) {
        $status = '&#8226 Available';
        $statusClass = 'available';
        } else if ($school -> accreditation_status == 3) {
        $status = '&#8226 Restricted';
        $statusClass = 'not-available';
        }
        @endphp
        <tr>
            <td><img src="/{{($school->profile_image) }}" class="rounded-circle" style="width: 40px; height: 40px"
                    alt="Avatar" />
            </td>
            <td>{{$school -> name}}<br>
                <span class="{{ $statusClass }}">{!! $status !!}</span>
            </td>
            <td>{{$school -> address}}</td>
            <td>{{ \Carbon\Carbon::parse($school -> date_created)->format('F j, Y') }}</td>
            <td>{{$school -> total_students}}</td>
            <td>{{$school ->  total_instructors}}</td>
            <td>{{$school -> availed_service_count}}</td>
            <td>{{$school -> completion_rate}} %</td>
            <td>

                <div class="dropdown">
                    <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">

                    </i>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.schools.details', $school -> user_id)}}">More
                                Details</a></li>
                        <li><a class="dropdown-item" href="#">Restrict</a></li>
                    </ul>
                </div>
            </td>

        </tr>
        @endforeach
    </tbody>


</table>