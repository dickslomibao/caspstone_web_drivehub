<script>
    $(document).ready(function() {
        $('#table10').DataTable();
    });
</script>


<br>
<center>
    <h5 id="title"><b> Top Performing School {{ \Carbon\Carbon::parse($month)->format('F') }} {{$year}}
        </b>
    </h5>
</center>


<div class="row">
    <div class="col-12 mx-auto">

        <table id="table10" class="table" style="width:100%">
            <thead>
                <tr>
                    <th>
                    </th>
                    <th>Driving School</th>
                    <th>Location</th>
                    <th>No. of Booked Order</th>
                    <th>Completion Rate</sth>
                    <th>Average Rate</th>


                </tr>
            </thead>
            <tbody>
                @foreach ($topSchool as $school)

                @php

                $address = $school->address;
                $addressParts = explode(',', $address);

                $city = trim($addressParts[count($addressParts) - 3]);
                $province = trim($addressParts[count($addressParts) - 2]);

                @endphp
                <tr>
                    <td>
                        <img src="/{{($school->profile_image) }}" class="rounded-circle" style="width: 40px; height: 40px" alt="Avatar" />
                    <td>{{ $school->name }}</td>
                    <td>{{ $city . ', ' .$province}}</td>
                    <td>{{ $school-> availed_service_count}}</td>
                    <td>{{ $school->completion_rate}} % </td>
                    <td>{{ $school->average_rating}} <i class="fa-solid fa-star" id="logo1"></i></td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</div>