@include('admin.includes.header', ['title' => 'Dashboard'])


@php
$currentYear = date('Y');
$currentMonth = date('F');
$lastMonth = date('F', strtotime('-1 month'));



@endphp


<div class="container-fluid" style="padding: 20px;margin-top:60px">



    <div class="row" style="margin-bottom: 20px;">
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
                    <button type="submit" id="filterbutton" class="btn btn-primary w-100" style="background-color: var(--primaryBG);border:none">Filter</button>
                </div>
            </div>
        </div>
    </div>
    <div id="filterresult">
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
                            <h5><b>Driving Schools Registration Growth in {{$currentYear}}</h5></b>
                        </center>

                        <canvas id="schoolChart" style="width:100%;max-width:700px"></canvas>

                    </div>
                </div>



                <div class="col">
                    <div class="card rounded">
                        <center>
                            <h5><b>Student Drivers Growth in {{$currentYear}}</h5></b>
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
                            <h5><b>Top Performing School Last Month {{$lastMonth}} </h5>
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



                <!-- <div class="col">
                    <div class="card border">
                        <center>
                            <h5><b>New Posted Reviews</b></h5>
                        </center>

                        <div class="posted" style="font-weight: 400;">
                            @if(count($reviews))
                            @foreach ( $reviews as $review)

                            @php

                            $anonymity = "";
                            if($review->anonymous == 1){
                            $anonymity = "Initials Hidden";
                            }else{
                            $anonymity = $review->firstname . ' ' . $review->middlename . ' ' . $review->lastname;
                            }
                            @endphp

                            @for($i = 1; $i<= $review->rating; $i++)
                                <i class="fa-solid fa-star" id="logo1"></i>

                                @endfor @for($i = 1; $i<= 5 -$review->rating ; $i++)
                                    <i class="fa-solid fa-star" id="logo2"></i>

                                    @endfor
                                    <br>
                                    <h6>{{$review->content}}</h6>
                                    <b>Driving School:</b> {{$review -> school_name}} | {{$review->email}}<br>
                                    <span class="f2">{{ $anonymity}} •
                                        {{ \Carbon\Carbon::parse($review -> date_created)->format('F j, Y') }}</span>

                                    <hr style="height:1Spx;border-width:0;color:gray;background-color:gray">

                                    @endforeach
                                    <div style="margin-top: 10px;">
                                        <center>
                                            <h6> View <a href="{{ route('school.filterOrderGrowthPage') }}"> Reviews
                                                </a></h6>
                                        </center>
                                    </div>
                                    @else


                                    <center>No Data Available</center>
                                    <hr style="height:1px;border-width:0;color:gray;background-color:gray">
                                    @endif


                        </div>



                    </div>
                </div> -->

            </div>
        </div>
    </div>


    <div id="map" style="width: 100%;height:300%;"></div>






</div>


<script>
    var pusher = new Pusher('40178e8c6a9375e09f5c', {
        cluster: 'ap1'
    });
</script>

<script>
    function initMap() {
        if (typeof google === 'undefined') {
            console.error('Google Maps API is not loaded');
            return;
        }

        const myLatlng = {
            lat: 16.566233,
            lng: 121.262634
        };
        const mapOptions = {
            zoom: 7,
            center: myLatlng,
        };
        map = new google.maps.Map(document.getElementById("map"), mapOptions);

        if (schoolsData && schoolsData.length > 0) {
            schoolsData.forEach(school => {
                const {
                    school_lat,
                    school_lng,
                    school_name
                } = school;
                const schoolLatLng = new google.maps.LatLng(school_lat, school_lng);

                const marker = new google.maps.Marker({
                    position: schoolLatLng,
                    map: map,
                    title: school_name,
                });

                google.maps.event.addListener(marker, 'click', function() {
                    if (!infoWindow) {
                        infoWindow = new google.maps.InfoWindow();
                    }
                    infoWindow.setContent(`School Name: ${school_name}`);
                    infoWindow.open(map, marker);
                });
            });
        }
    }

    // Callback function for the Google Maps API script tag
    function initializeMap() {
        initMap();
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initializeMap&v=weekly" defer></script>

<script>
    // Initialize the map
    initializeMap();
</script>






<script>
    var school = <?php echo json_encode($schoolData); ?>;
    var xValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    new Chart("schoolChart", {
        type: "line",
        data: {
            labels: xValues,
            datasets: [{
                label: "Driving Schools",
                data: school,
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



    ///revision
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
                url: '{{ route('admin.filter.dashboard') }}',
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

@include('admin.includes.footer')