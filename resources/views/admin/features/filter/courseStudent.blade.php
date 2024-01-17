<table id="table_id10" class="table" style="width:100%">
    <thead>
        <tr>
            <th></th>
            <th>Student Name</th>
            <th>Email</th>
            <th>Registration Date</th>
            <th>Status</th>
        </tr>
    <tbody>
        @foreach ($students as $student)
        <tr>
            <td><img src="/{{($student->profile_image) }}" class="rounded-circle" style="width: 40px; height: 40px"
                    alt="Avatar" /></td>
            <td>{{$student -> firstname . ' '. $student -> middlename . ' '. $student -> lastname }}</td>
            <td>{{$student -> email}}</td>
            <td>{{ \Carbon\Carbon::parse($student -> date_created)->format('F j, Y') }}</td>
            <td>{{$student -> status}}</td>
        </tr>
        @endforeach

    </tbody>
    </thead>

</table>

<script>
$(document).ready(function() {
    $('#table_id10').DataTable();
});
</script>