@include('admin.includes.header', ['title' => 'Driving School Profile'])


@php
$currentYear = date('Y');
$currentMonth = date('F');
$lastMonth = date('F', strtotime('-1 month'));
@endphp




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





                    <h5><b>Total Availed Courses & Completion Rate Year <span id="taon">{{$currentYear}}<span></b></h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-sm-5"> <label for="">Filter Year</label>
                                    <input type="hidden" id="schoolID" value="{{$details->user_id}}">
                                    <input type="number" name="year" id="year" value="{{$currentYear}}" class="form-control mb-3" max="4" required>
                                </div>
                                <div class="col-sm-3"><label for=""></label>
                                    <label for=""></label>

                                    <button type="submit" id="filterbutton" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div id="filterresult">
                        <div class="col-11 mx-auto p-2">
                            <div class="p-3 border bg-light" id="box1">
                                <canvas id="orderChart" style="width:100%;max-width:600px"></canvas>


                            </div>
                        </div>
                        <div class="col-11 mx-auto p-2">
                            <div class="p-3 border bg-light" id="box1">
                                <canvas id="completionChart" style="width:100%;max-width:600px"></canvas>

                            </div>
                        </div>
                    </div>












                </div>
            </div>

        </div>
    </div>






</div>

<script>
    $(document).ready(function() {




        $('#filterbutton').click(function() {

            var year = $('#year').val();
            var schoolID = $('#schoolID').val();
            $('#taon').text(year);

            $.ajax({
                url: '{{route("admin.filter.yearSchoolGraph") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    schoolID: schoolID,
                    year: year,
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


        });
    });
</script>




<script>
    var school = <?php echo json_encode($services); ?>;
    var xValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    new Chart("orderChart", {
        type: "line",
        data: {
            labels: xValues,
            datasets: [{
                label: "No.  of Courses / Services",
                data: school,
                borderColor: "blue",
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
    var xValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    var completion = <?php echo json_encode($completion); ?>;


    new Chart("completionChart", {
        type: "bar",
        data: {
            labels: xValues,
            datasets: [{
                label: "Completion Rate",
                backgroundColor: "#582ff5",
                data: completion
            }]
        },
        options: {
            legend: {
                display: true, // Ensure that this is set to true to display the legend
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                    },
                }],
            },
            title: {
                display: true,
                text: "Completion Rate"
            }
        }
    });
</script>






@include('admin.includes.footer')