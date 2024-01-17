<script>
$(document).ready(function() {
    $('#table1').DataTable();
});
</script>



<div class="w-100 d-flex justify-content-between table-header-btn">
    <div class="d-flex" style="gap:15px">
        <a class="btn-outline-light"
            href="/school/theoreticalSched/{{$status}}/{{$start_date}}/{{$end_date}}/export_pdf"><i
                class="fa-solid fa-file-export"></i>Export
            PDF</a>
    </div>
    <a href="{{ route('create.theoritical') }}">
        <button class="btn-add-management" id="modal_btn" onclick=""><i class="fa-solid fa-plus"></i>
            Create new
            Schedules </button></a>
</div>

<table id="table1" class="table1" style="width:100%">
    <thead>
        <tr>
            <th>Title</th>
            <th>Slot</th>
            <th>Scheduled Date</th>
            <th>Status</th>
            <th width="50">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ( $schedules as $schedule)
        @php
        $statusClass = '';

        if ($schedule->status == 1) {
        $status = 'Waiting';
        $statusClass = 'waiting';
        } else if ($schedule->status == 2) {
        $status = 'Started';
        $statusClass = 'started';
        } else if ($schedule->status == 3) {
        $status = 'Completed';
        $statusClass = 'completed';
        }
        @endphp
        <tr>
            <td>{{$schedule -> title}}</td>
            <td>{{$schedule -> slot}}</td>
            <td>{{ \Carbon\Carbon::parse($schedule->date_created)->format('F j, Y | h:i:s A') }}</td>
            <td><span class="{{ $statusClass }}">{{ $status }}</span></td>
            <td>
                <div class="dropdown">
                    <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">

                    </i>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/school/theoritical/{{$schedule->id}}/view">View
                                Schedules</a></li>
                        <li><a class="dropdown-item" href="/school/theoritical/{{$schedule->id}}/update"
                                role="button">Update</a></li>
                        <li><a class="dropdown-item" href="#">Delete</a></li>
                    </ul>
                </div>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>