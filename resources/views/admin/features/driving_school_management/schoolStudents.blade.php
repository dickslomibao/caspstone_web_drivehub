@include('admin.includes.header', ['title' => 'Driving School Students'])


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

                @include('admin.features.driving_school_management.partials.details', [
                'schoolName' => $details->name,
                'schoolDate' => \Carbon\Carbon::parse($details->date_created)->format('F j, Y'),
                'schoolImage' => $details->profile_image,
                'schoolAddress' => $details->address,
                'schoolRating' => $details->average_rating, // Replace with the actual rating
                'schoolReviews' => $details->total_reviews, // Replace with the actual number of reviews
                ])


            </div>

            <div class="col-xl-8">
                <div class="card border">


                    @include('admin.features.driving_school_management.partials.new_nav', [
                    'school_id' => $details->user_id,
                    ])

                    <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                    <br>





                    <h5><b>Student Drivers Growth in <span id="taonG">{{$currentYear}}<span></b></h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-sm-5"> <label for="">Filter Year</label>
                                    <input type="hidden" id="schoolIDG" value="{{$details->user_id}}">
                                    <input type="number" name="year" id="yearG" value="{{$currentYear}}"
                                        class="form-control mb-3" max="4" required>
                                </div>
                                <div class="col-sm-3">
                                    <br>

                                    <button type="submit" id="filterbuttonGraph" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div id="filterresultGraph">
                        <div class="col-11 mx-auto p-2">
                            <div class="card border ">
                                <canvas id="studentChart" style="width:100%;max-width:600px"></canvas>
                            </div>
                        </div>

                    </div>












                </div>
            </div>

        </div>
    </div>




    <div class="card border mt-5">
        <center>
            <h4 id="title"><b>STUDENTS ENROLLED FOR THE MONTH OF <span
                        id="buwan">{{mb_strtoupper($lastMonth)}}<span></b></h4>
            <h4><b><span id="taon">{{$currentYear}}<span></b></h4>
        </center><br>


        <div class="row">

            <div class="col-md">

                <div class="row">

                    <div class="col-sm-5">

                    </div>

                    <div class="col-sm-3"><label for="">Month</label>
                        <input type="hidden" name="schoolID" id="schoolID" value="{{$details->user_id}}"
                            class="form-control mb-3" required>
                        <select name='month' id="month" class='form-select mb-3' name="month" required>
                            <option value="January" {{$lastMonth== 'January' ? 'selected' : '' }}>January</option>
                            <option value="February" {{$lastMonth== 'February' ? 'selected' : '' }}>February</option>
                            <option value="March" {{$lastMonth== 'March' ? 'selected' : '' }}>March</option>
                            <option value="April" {{$lastMonth== 'April' ? 'selected' : '' }}>April</option>
                            <option value="May" {{$lastMonth== 'May'? 'selected' : '' }}>May</option>
                            <option value="June" {{$lastMonth== 'June' ? 'selected' : '' }}>June</option>
                            <option value="July" {{$lastMonth== 'July'? 'selected' : '' }}>July</option>
                            <option value="August" {{$lastMonth== 'August'? 'selected' : '' }}>August</option>
                            <option value="September" {{$lastMonth== 'September'? 'selected' : '' }}>September</option>
                            <option value="October" {{$lastMonth== 'October'? 'selected' : '' }}>October</option>
                            <option value="November" {{$lastMonth== 'November'? 'selected' : '' }}>November</option>
                            <option value="December" {{$lastMonth== 'December'? 'selected' : '' }}>December</option>
                        </select>


                    </div>

                    <div class="col-sm-3"> <label for="">Year</label>
                        <input type="number" name="year" id="year" value="{{$currentYear}}" class="form-control mb-3"
                            required>

                    </div>

                    <div class="col-1">
                        <center><br><button type="submit" id="filterbutton" class="btn btn-primary">Filter</button>
                        </center>
                    </div>


                </div>

            </div>
        </div>

        <div id="filterresult">
            <table id="table" class="table" style="width:100%">
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
                                <img src="/{{$student-> profile_image}}" class="rounded-circle"
                                    style="width: 40px;height:40px;object-fit: cover;" alt="Avatar" />
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
        </div>

    </div>





</div>

<script>
$(document).ready(function() {




    $('#filterbuttonGraph').click(function() {

        var year = $('#yearG').val();
        var schoolID = $('#schoolIDG').val();
        $('#taonG').text(year);

        $.ajax({
            url: '{{route("admin.filter.schoolStudent") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                schoolID: schoolID,
                year: year,
            },
            success: function(response) {
                $('#filterresultGraph').html(response);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log("Error Thrown: " + errorThrown);
                console.log("Text Status: " + textStatus);
                console.log("XMLHttpRequest: " + XMLHttpRequest);
                console.warn(XMLHttpRequest.responseText)
            }
        });


    });



    //for the table
    $('#filterbutton').click(function() {

        var year = $('#year').val();
        var month = $("#month").val();
        var schoolID = $('#schoolID').val();

        let newmonth = month.toUpperCase();
        $('#taon').text(year);
        $('#buwan').text(newmonth);

        $.ajax({
            url: '{{route("admin.filter.studentTable") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                year: year,
                month: month,
                schoolID: schoolID,
            },
            success: function(html) {
                $('#filterresult').html(html);
                console.log(html); // Update the content of the div
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log("Error Thrown: " + errorThrown);
                console.log("Text Status: " + textStatus);
                console.log("XMLHttpRequest: " + XMLHttpRequest);
                console.warn(XMLHttpRequest.responseText)
            }
        });

    });
});
</script>




<script>
var studentNo = <?php echo json_encode($studentGraph); ?>;
var xValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
new Chart("studentChart", {
    type: "line",
    data: {
        labels: xValues,
        datasets: [{
            label: "No. of Student",
            data: studentNo,
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









@include('admin.includes.footer')