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


<div class="row">
    <div class="col-lg-9">
        <div class="row">
            <div class="col-lg-4">
                <div class="d-card">
                    <h5> No. of student</h5>
                    <h2>{{ $totalstudents }}</h2>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="d-card">
                    <h5> No. of courses</h5>
                    <h2>{{ $totalcourses }}</h2>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="d-card">
                    <h5> Total availed courses</h5>
                    <h2>{{ $totalservices }}</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="d-card">
                    <h5> No. of vehicles</h5>
                    <h2>{{ $totalvehicles }}</h2>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="d-card">
                    <h5> No. of pending orders</h5>
                    <h2>{{ $totalpending }}</h2>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="d-card">
                    <h5> Revenue this month</h5>
                    <h2>{{ number_format($totalrevenue, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6" style="margin-top: 20px">
                <div class="card ">
                    <center>
                        <h5><b>Student Registration Growth {{ $dateString }}</h5></b>
                    </center>

                    <canvas id="studentChart" style="width:100%;max-width:700px"></canvas>
                    <br>
                    <h6>
                        <center> Filter Student Growth <a href="{{ route('school.filterStudentGrowthPage') }}">
                                Yearly
                            </a></center>
                    </h6>
                </div>
            </div>
            <div class="col-lg-6" style="margin-top: 20px">
                <div class="card ">
                    <center>
                        <h5><b> Completed Order {{ $dateString }}</h5></b>
                    </center>
                    <canvas id="orderChart" style="width:100%;max-width:700px"></canvas>
                    <br>
                    <h6>
                        <center> Filter Order Growth <a href="{{ route('school.filterOrderGrowthPage') }}">
                                Yearly </a>
                        </center>
                    </h6>
                </div>
            </div>
            <div class="col-12" style="margin-top: 20px">
                <div class="card ">
                    <center>
                        <h5><b>Revenue {{ $dateString }}</h5></b>
                    </center>
                    <canvas id="revenueChart" style="width:100%"></canvas>
                    <br>
                    <h6>
                        <center> Filter Revenue <a href="{{ route('school.filterRevenueGrowthPage') }}">
                                Yearly </a>
                        </center>
                    </h6>
                </div>
            </div>

        </div>
    </div>
    <div class="col-lg-3">
        <h6 style="margin-top: 15px">Your Reviews ({{count($reviews)}})</h6>

        <div class="row">
            @foreach ($reviews as $review)
            <div class="col-" style="border-bottom:1px solid rgba(0,0,0,0.05);padding:15px;">
                <div class="d-flex align-items-center justify-content-between" style="column-gap:10px">
                    <div class="d-flex align-items-center" style="column-gap:10px">
                        <img src="/{{ $review->profile_image }}" alt="" style="width: 25px;height:25px;object-fit:cover;border-radius:50%">
                        <div>
                            <h6 style="font-weight: 500;font-size:15px;">
                                {{ $review->firstname }} {{ $review->lastname }}
                            </h6>

                        </div>
                    </div>
                </div>
                <pre style="font-weight: 500;font-size:13px;margin-top:10px">{{ $review->content }}</pre>
                <h6 style="font-weight: 500;font-size:13px;margin-top:5px">Date Posted:
                    {{ $review->date_created }}
                </h6>
            </div>
            @endforeach
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
        var orderData = <?php echo json_encode($orderData); ?>;

        var oLabel = orderData.map(entry => entry.day);
        var orderCounts = orderData.map(entry => entry.count_of_orders);

        new Chart("orderChart", {
            type: "bar",
            data: {
                labels: oLabel,
                datasets: [{
                    label: "No. of Orders",
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

        //revenueGraph
        var revenueData = <?php echo json_encode($revenueData); ?>;

        var rLabel = revenueData.map(entry => entry.day);
        var totalRev = revenueData.map(entry => entry.total_revenue);

        new Chart("revenueChart", {
            type: "line",
            data: {
                labels: rLabel,
                datasets: [{
                    label: "Revenue",
                    data: totalRev,
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