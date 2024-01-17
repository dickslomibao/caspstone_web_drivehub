<script>
$(document).ready(function() {
    $('#table10').DataTable();
});
</script>

<table id="table10" class="table" style="width:100%">
    <thead>
        <tr>
            <th>Course</th>
            <th>Total Order</th>

        </tr>
    </thead>
    <tbody>
        @foreach ( $courses as $course)
        <tr>
            <td>{{$course -> name}}</td>
            <td>{{$course -> availed_service_count}}</td>

        </tr>
        @endforeach
    </tbody>

</table>