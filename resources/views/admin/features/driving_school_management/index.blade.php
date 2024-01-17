@include('admin.includes.header', ['title' => 'Driving School Management'])


<script>
    $(document).ready(function() {
        $('#table').DataTable();

    });
</script>
<div class="container-fluid" style="padding: 20px;margin-top:60px">
    <div class="row">
        <div class="col-12">
            <!-- <div class="w-100 d-flex justify-content-between table-header-btn">
                <div class="d-flex" style="gap:15px">
                    <button class="btn-outline-light"><i class="fa-solid fa-file-export"></i>Export CSV</button>

                </div>
                <a href="{{ route('admin.registerSchool') }}">
                    <button class="btn-add-management">
                        <i class="fa-solid fa-plus"></i> Add new Driving School
                    </button>
                </a>

            </div> -->
            <div class="row">
                <div class="col-sm-2"> <label for="">Status</label>
                    <select id="status" class='form-select mb-3' name="status" required>
                        <option value="0" selected>All</option>
                        <option value="2">Available</option>
                        <option value="3">Restricted</option>

                    </select>
                </div>
                <div class="col-sm-3" id="changeradio">
                </div>
                <div class="col-sm-3"><label for="">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control mb-3" required>
                </div>
                <div class="col-sm-3"> <label for="">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control mb-3" required>
                </div>
                <div class="col-1">
                    <center><br><button type="submit" id="filterbutton" class="btn btn-primary">Filter</button></center>
                </div>
            </div>
            <div id="filterresult">
                <table id="table" class="table" style="width:100%">

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
                            <td><img src="/{{($school->profile_image) }}" class="rounded-circle" style="width: 40px; height: 40px" alt="Avatar" />
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
                                    <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown" aria-expanded="false">

                                    </i>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('admin.schools.details', $school -> user_id)}}">More
                                                Details</a></li>
                                        {{-- <li><a class="dropdown-item" href="#">Restrict</a></li> --}}
                                    </ul>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>


                </table>
            </div>
        </div>
    </div>
</div>


<script>
    $('#filterbutton').click(function() {
        var status = $('#status').val();
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();


        var startDateObj = new Date(start_date);
        var endDateObj = new Date(end_date);

        if (!start_date && !end_date) {
            swal({
                icon: "error",
                title: 'Both Start Date and End Date are Empty',
                text: " ",

            });
        } else if (!start_date || !end_date) {
            swal({
                icon: "error",
                title: 'Invalid Date Range There is an Empty Date',
                text: " ",

            });
        } else if ((startDateObj > endDateObj) || (endDateObj < startDateObj)) {
            swal({
                icon: "error",
                title: 'Invalid Date Range',
                text: " ",
            });
        } else {
            $.ajax({
                url: '{{route("admin.school.filter.availability")}}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status,
                    start_date,
                    end_date,
                },
                success: function(response) {
                    $('#filterresult').html(response);

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log("Error Thrown: " + errorThrown);
                    console.log("Text Status: " + textStatus);
                    console.log("XMLHttpRequest: " + XMLHttpRequest);
                    console.warn(XMLHttpRequest.responseText)
                }
            });
        }
    });
</script>




@include('admin.includes.footer')