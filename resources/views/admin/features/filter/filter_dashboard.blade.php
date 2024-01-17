<?php if ($start_date == $end_date) {
    $date = new DateTime($start_date);
    $formattedDate = $date->format('F j, Y');
    $dateString = " From " . $formattedDate;
} else {
    $firstdate = new DateTime($start_date);
    $secdate = new DateTime($end_date);
    $formattedDate1 = $firstdate->format('M d, Y');
    $formattedDate2 = $secdate->format('M d, Y');
    $dateString = " From " . $formattedDate1 . " To " . $formattedDate2;
}

?>

<div class="row row-cols-1 row-cols-lg-3 g-1 g-lg-3">
    <div class="col">
        <div class="p-3 border" id="box0">
            <span class="dash1">NO. OF ACCREDITED DRIVING SCHOOLS
            </span>

            <div class="row">

                <div class="col-9">
                    <h4><b>{{ $totalschool }}</b> Driving Schools</h4>
                </div>
                <div class="col-3">
                    <h4><i id="userr" class="fa-solid fa-school-flag"></i></h4>
                </div>
            </div>

        </div>
    </div>
    <div class="col">
        <div class="p-3 border" id="box2">

            <span class="dash1">NO. OF STUDENT DRIVERS</span>

            <div class="row">
                <div class="col-9">
                    <h4><b>{{ $totalstudents}}</b> Student Drivers</h4>

                </div>
                <div class="col-3">
                    <h4><i id="userr1" class="fa-solid fa-users"></i></h4>
                </div>
            </div>


        </div>
    </div>
    <div class="col">
        <div class="p-3 border" id="box3">

            <span class="dash1">NO. OF PENDING REQUEST</span>

            <div class="row">
                <div class="col-9">
                    <h4><b> {{ $pending }}</b> Driving Schools</h4>

                </div>
                <div class="col-3">
                    <h4><i id="userr2" class="fa-solid fa-school-circle-exclamation"></i></h4>
                </div>
            </div>


        </div>
    </div>




</div>





<div class="container my-5">
    <div class="row row-cols-1 row-cols-lg-2 g-1 g-lg-4 ">




        <div class="col">
            <div class="card rounded">
                <center>
                    <h5><b>Driving Schools Registration Growth in {{ $dateString }}</h5></b>
                </center>

                <canvas id="schoolChart" style="width:100%;max-width:700px"></canvas>

            </div>
        </div>



        <div class="col">
            <div class="card rounded">
                <center>
                    <h5><b>Student Drivers Growth in {{ $dateString }}</h5></b>
                </center>

                <canvas id="studentChart" style="width:100%;max-width:700px"></canvas>

            </div>
        </div>

    </div>
</div>



<div class="container my-5">
    <div class="row row-cols-1 row-cols-lg-1 g-1 g-lg-4 ">
        <div class="col">
            <div class="card rounded">
                <center>
                    <h5><b>Top Performing School {{ $dateString }}
                </center>

                <br>



                <table id="table" class="table" style="width:100%">
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
                            <td>{{ $school-> average_rating}} <i class="fa-solid fa-star" id="logo1"></i></td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>



                <h6>
                    <center> Filter <a href="{{ route('admin.filter.topSchool') }}">Top Performing School </a>
                    </center>
                </h6>


            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {



        var studentData = <?php echo json_encode($studentData); ?>;

        var xValues = studentData.map(entry => entry.day);
        var studentCounts = studentData.map(entry => entry.count_of_students);

        new Chart("studentChart", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                    label: "Student Drivers",
                    data: studentCounts,
                    borderColor: "rgba(84, 94, 225)",
                    backgroundColor: "rgba(0, 0, 255, 0.3)",
                    fill: true
                }]
            },
            options: {
                legend: {
                    display: true,
                    position: 'bottom'
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });



        //orderGraph 
        var orderData = <?php echo json_encode($schoolData); ?>;

        var oLabel = orderData.map(entry => entry.day);
        var orderCounts = orderData.map(entry => entry.count_of_schools);

        new Chart("schoolChart", {
            type: "bar",
            data: {
                labels: oLabel,
                datasets: [{
                    label: "Driving Schools",
                    data: orderCounts,
                    borderColor: "rgba(84, 94, 225)",
                    backgroundColor: "rgba(0, 0, 255, 0.3)",
                    fill: true
                }]
            },
            options: {
                legend: {
                    display: true,
                    position: 'bottom'
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });




    });
</script>