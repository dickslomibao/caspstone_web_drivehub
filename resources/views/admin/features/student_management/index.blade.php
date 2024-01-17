@include('admin.includes.header', ['title' => 'Student Management'])



<script>
$(document).ready(function() {
    $('#table_id').DataTable();

});
</script>

<div class="container-fluid" style="padding: 20px;margin-top:60px">


    <div class="row">
        <div class="col-12">
            <div class="w-100 d-flex justify-content-between table-header-btn">
                <div class="d-flex" style="gap:15px">
                    <button class="btn-outline-light"><i class="fa-solid fa-file-export"></i>Export CSV</button>
                    <button class="btn-outline-light"><i class="fa-solid fa-file-export"></i>Import CSV</button>
                </div>

            </div>
            <table id="table_id" class="table" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Student Name</th>
                        <th>Email</th>
                        <th>Signup Date</th>
                        <th>No. of Courses Enrolled</th>
                        <th>Completion Rate</th>
                        <th style="width: 60px">Action</th>
                    </tr>
                <tbody> @foreach ($students as $student)
                    <tr>


                        <td> <img src="/{{($student->profile_image) }}" class="rounded-circle"
                                style="width: 40px;height:40px" alt="Avatar" /></td>
                        <td>{{$student -> firstname . ' '. $student -> middlename. ' '. $student -> lastname}}</td>
                        <td>{{$student -> email}}</td>
                        <td>{{ \Carbon\Carbon::parse($student -> date_created)->format('F j, Y') }}</td>
                        <td>{{$student -> availed_service_count}}</td>
                        <td>{{$student -> completion_rate}} %</td>
                        <td>
                            <div class="dropdown">
                                <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">

                                </i>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="{{ route('admin.student.details', $student -> student_id)}}">More
                                            Details</a></li>
                                    <li><a class="dropdown-item update" role="button">Restrict</a></li>
                                    <li><a class="dropdown-item" href="#">Delete</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>


                </thead>

            </table>
        </div>
    </div>

</div>




@include('admin.includes.footer')