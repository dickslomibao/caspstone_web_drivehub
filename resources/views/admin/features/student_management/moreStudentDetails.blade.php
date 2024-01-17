@include('admin.includes.header', ['title' => 'Driving School Profile'])


@php
$currentYear = date('Y');
$currentMonth = date('F');
$lastMonth = date('F', strtotime('-1 month'));
@endphp





<script>
$(document).ready(function() {
    $('#table').DataTable();

});
</script>



<div class="container-fluid" style="padding: 20px;margin-top:60px">


    <div class="container px-4 mt-20">

        <div class="row gx-4">

            <div class="col-xl-4">


                @include('admin.features.driving_school_management.partials.studentDetails', [
                'firstName' => $details->firstname,
                'middleName' => $details->middlename,
                'lastName' => $details->lastname,
                'registrationDate' => \Carbon\Carbon::parse($details->date_created)->format('F j, Y'),
                'studentImage' => $details->profile_image,
                'email' => $details->profile_image,
                'orderCount' => $details-> availed_service_count
                ])


            </div>

            <div class="col-xl-8">
                <div class="p-3 border" id="cont1">



                    <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                    <br>





                    <h5><b>Courses Booked</b></h5>

                    <br>

                    <div id="filterresult">

                        <div style="overflow-x:auto;">

                            <table id="table" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Driving School</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Course Name</th>
                                        <th>No. Availed Services</th>
                                        <th>Completion Rate</th>

                                    </tr>
                                <tbody>
                                    @foreach ($courses as $course)
                                    <tr>
                                        <td><img src="/{{($course->profile_image) }}" class="rounded-circle"
                                                style="width: 40px; height: 40px" alt="Avatar" /></td>
                                        <td>{{$course -> name}}</td>
                                        <td>{{$course -> email}}</td>
                                        <td>{{$course -> address}}</td>
                                        <td>{{$course -> course_name}}</td>
                                        <td>{{$course -> availed_service_count}}</td>
                                        <td>{{$course -> completion_rate}} %</td>


                                    </tr>
                                    @endforeach
                                </tbody>
                                </thead>

                            </table>
                        </div>
                    </div>












                </div>
            </div>

        </div>
    </div>






</div>



@include('admin.includes.footer')