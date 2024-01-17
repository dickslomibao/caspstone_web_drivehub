<table id="table_id10" class="table" style="width:100%">
    <thead>
        <tr>
            <th>Name</th>
            <th>Sex</th>
            <th>Phone Number</th>
            <th>Birthdate</th>
            <th>Address</th>
            <th>Mobile Number</th>
            <th>Date Created</th>
        </tr>

    </thead>
    <tbody>
        @foreach ( $students as $student)
        <tr>
            <td>
                <div class="d-flex align-items-center" style="gap: 10px;padding:5px 0">
                    <img src="/{{$student-> profile_image}}" class="rounded-circle" style="width: 40px;height:40px;object-fit: cover;" alt="Avatar" />
                    <div>
                        <h6>{{$student-> firstname}} {{$student->middlename}} {{$student->lastname}}</h6>
                        <p style="font-size:14px" class="email">{{$student-> email}}</p>
                    </div>
                </div>

            </td>

            <td>{{$student -> sex}}</td>
            <td>{{$student -> phone_number}}</td>
            <td>{{ \Carbon\Carbon::parse($student -> birthdate)->format('F j, Y') }}</td>
            <td>{{$student -> address}}</td>
            <td>{{$student -> phone_number}}</td>
            <td>{{ \Carbon\Carbon::parse($student -> date_created)->format('F j, Y | h:i:s A') }}</td>
        </tr>

        @endforeach
    </tbody>
</table>



<script>
    $(document).ready(function() {
        $('#table_id10').DataTable();
    });
</script>