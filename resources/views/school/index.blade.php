@include(SchoolFileHelper::$header, ['title' => 'Dashboard'])
<style>
    .d-card {
        border: 1px solid rgba(0, 0, 0, .05);
        padding: 20px;
        margin-top: 15px;
        border-radius: 10px;
    }

    .d-card h5 {
        margin-bottom: 5px;

    }
</style>
@php
    $currentYear = date('Y');
    $currentMonth = date('F');
    $lastMonth = date('F', strtotime('-1 month'));
@endphp

<div class="container-fluid" style="padding: 20px;margin-top:40px">

    {{--
    <div class="row mt-2">
        <div class="col-sm-5">

        </div>
        <div class="col-sm-3">
        </div>
        <div class="col-sm-3"> 
        </div>
        <div class="col-1">
            <center><br>
            </center>
        </div>
    </div> --}}
    <div class="row" style="margin-top: 15px">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-5">
                    <label for="" style="margin-bottom: 10px">Start Date:</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" required>
                </div>
                <div class="col-lg-5"><label for="" style="margin-bottom: 10px">End Date:</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" required>

                </div>
                <div class="col-lg-2 d-flex" style="justify-content: flex-end; align-items: flex-end">
                    <button type="submit" id="filterbutton" class="btn btn-primary w-100"
                        style="background-color: var(--primaryBG);border:none">Filter</button>
                </div>
            </div>
        </div>
    </div>
    <div id="filterresult">
        <div class="row" style="margin-top: 20px">
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
                                <h5><b>Student Registration Growth in {{ $currentYear }}</h5></b>
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
                                <h5><b> Completed Order in {{ $currentYear }}</h5></b>
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
                                <h5><b>Revenue in {{ $currentYear }}</h5></b>
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
                <h6 style="margin-top: 15px">Your Reviews ({{ count($reviews) }})</h6>

                <div class="row">
                    @foreach ($reviews as $review)
                        <div class="col-" style="border-bottom:1px solid rgba(0,0,0,0.05);padding:15px;">
                            <div class="d-flex align-items-center justify-content-between" style="column-gap:10px">
                                <div class="d-flex align-items-center" style="column-gap:10px">
                                    <img src="/{{ $review->profile_image }}" alt=""
                                        style="width: 25px;height:25px;object-fit:cover;border-radius:50%">
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
    </div>



    {{-- <div class="card border">
        <center>
            <h5><b>New Posted Reviews</b></h5>
        </center>
        <div class="posted">
            @if (count($reviews))
                @foreach ($reviews as $review)
                    @php

                        $anonymity = '';
                        if ($review->anonymous == 1) {
                            $anonymity = 'Initials Hidden';
                        } else {
                            $anonymity = $review->firstname . ' ' . $review->middlename . ' ' . $review->lastname;
                        }
                    @endphp

                    @for ($i = 1; $i <= $review->rating; $i++)
                        <i class="fa-solid fa-star" id="logo1"></i>
                        @endfor @for ($i = 1; $i <= 5 - $review->rating; $i++)
                            <i class="fa-solid fa-star" id="logo2"></i>
                        @endfor
                        <br>
                        <h6>{{ $review->content }}</h6>
    Course: {{ $review->name }} | Duration :
    {{ $review->duration }}hrs
    <br>
    <span class="f2">{{ $anonymity }} •
        {{ \Carbon\Carbon::parse($review->date_created)->format('F j, Y') }}</span>

    <hr style="height:1px;border-width:0;color:gray;background-color:gray">
    @endforeach
    <div style="margin-top: 10px;">
        <center>
            <h6> View <a href="{{ route('school.view.ratings') }}"> Reviews
                </a></h6>
        </center>
    </div>
    @else
    <center>No Data Available</center>
    <hr style="height:1px;border-width:0;color:gray;background-color:gray">
    @endif


</div>



</div> --}}

    <script>
        var student = <?php echo json_encode($studentData); ?>;
        var xValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        new Chart("studentChart", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                    label: "Student Drivers",
                    data: student,
                    borderColor: "rgba(84, 94, 225)",
                    backgroundColor: "rgba(0, 0, 255, 0.3)",
                    fill: true
                }]
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        });
    </script>



    <script>
        var student = <?php echo json_encode($orderData); ?>;
        var xValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        new Chart("orderChart", {
            type: "bar",
            data: {
                labels: xValues,
                datasets: [{
                    label: "No. of Orders",
                    data: student,
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
    </script>


    <script>
        var student = <?php echo json_encode($revenueData); ?>;
        var xValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        new Chart("revenueChart", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                    label: "Revenue",
                    data: student,
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


        //fiterrrrrr

        $('#filterbutton').click(function() {
            var status = $('#status').val();
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();

            var startDateObj = new Date(start_date);
            var endDateObj = new Date(end_date);

            ///revision
            var currentDate = new Date();
            currentDate.setHours(0, 0, 0, 0);
            endDateObj.setHours(0, 0, 0, 0);


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
            } else if (endDateObj > currentDate) {
                ///revision
                swal({
                    icon: "error",
                    title: 'End Date should be equal to or less than the current date',
                    text: " ",
                });
            } else {
                $.ajax({
                    url: '{{ route('school.filter.dashboard') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        start_date: start_date,
                        end_date: end_date,

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

    @include(SchoolFileHelper::$footer)
