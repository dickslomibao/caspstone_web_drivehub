@include('admin.includes.header', ['title' => 'Driving School Reports'])


@php
$currentYear = date('Y');
$currentMonth = date('F');
$lastMonth = date('F', strtotime('-1 month'));
@endphp




<script>
$(document).ready(function() {
    $('#table').DataTable();
    $('#table2').DataTable();

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

                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true"><b>ORDER</b></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                                aria-selected="false"><b>SALES</b></button>
                        </li>

                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab">

                            <!-- start of order -->

                            <div class="row row-cols-1 row-cols-lg-2 g-1 g-lg-3">
                                <div class="col">
                                    <div class="card border">

                                        <canvas id="weeklyChart" style="width:100%;max-width:700px"
                                            data-url="/admin/reports/retreiveWeekly/{{$details->user_id}}"></canvas>

                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card border">

                                        <canvas id="orderChart" style="width:100%;max-width:700px"></canvas>

                                    </div>
                                </div>


                            </div>



                            <div class="card border mt-3">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-sm-2">
                                            </div>

                                            <div class="col-sm-4"><label for="">Start Date</label>
                                                <input type="hidden" name="school_id" id="school_id"
                                                    value="{{$details->user_id}}">
                                                <input type="date" name="start_date" id="start_date"
                                                    class="form-control mb-3" required>
                                            </div>
                                            <div class="col-sm-4"> <label for="">End Date</label>
                                                <input type="date" name="end_date" id="end_date"
                                                    class="form-control mb-3" required>
                                            </div>
                                            <div class="col-2">
                                                <center><br><button type="submit" id="filterbutton"
                                                        class="btn btn-primary">Filter</button></center>
                                            </div>
                                        </div>
                                        <br>
                                        <div id="filterresult">

                                            <table id="table" class="table" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Course</th>
                                                        <th>Total Order</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ( $courses as $course)
                                                    <tr>
                                                        <td>{{$course -> name}}</td>
                                                        <td>{{$course -> availed_service_count}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- end of order -->
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                            aria-labelledby="pills-profile-tab">
                            <!-- start of sales -->


                            <div class="row row-cols-1 row-cols-lg-2 g-1 g-lg-3">
                                <div class="col">
                                    <div class="card border">

                                        <canvas id="weeklyChartSales" style="width:100%;max-width:700px"
                                            data-url="/admin/reports/retreiveWeeklySales/{{$details->user_id}}"></canvas>

                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card border">

                                        <canvas id="salesChart" style="width:100%;max-width:700px"></canvas>

                                    </div>
                                </div>


                            </div>



                            <div class="card border mt-3">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-sm-2">
                                            </div>

                                            <div class="col-sm-4"><label for="">Start Date</label>
                                                <input type="date" name="start_date1" id="start_date1"
                                                    class="form-control mb-3" required>
                                            </div>
                                            <div class="col-sm-4"> <label for="">End Date</label>
                                                <input type="date" name="end_date1" id="end_date1"
                                                    class="form-control mb-3" required>
                                            </div>
                                            <div class="col-2">
                                                <center><br><button type="submit" id="filterbutton1"
                                                        class="btn btn-primary">Filter</button></center>
                                            </div>
                                        </div>
                                        <br>
                                        <div id="filterresult1">

                                            <table id="table2" class="table" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Course</th>
                                                        <th>Total Order</th>
                                                        <th>Total Sales</th>
                                                        <th>Balance</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ( $sales as $sale)
                                                    @php $balance = $sale -> total_sales - $sale ->total_cash_payments;
                                                    @endphp
                                                    <tr>
                                                        <td>{{$sale -> name}}</td>
                                                        <td>{{$sale -> availed_service_count}}</td>
                                                        <td>{{number_format($sale -> total_sales, 2)}}</td>
                                                        <td>{{number_format($balance, 2)}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <!-- end of sales  -->


                        </div>

                    </div>
















                </div>
            </div>

        </div>
    </div>








</div>


<script>
    function updateWeeklyChart() {
        var chartCanvas = document.getElementById('weeklyChart');
        var dataUrl = chartCanvas.dataset.url;

        // Check if window.weeklyChart exists and is a valid Chart.js instance
        if (window.weeklyChart && window.weeklyChart.destroy) {
            window.weeklyChart.destroy();
        }

        // Make an AJAX request to fetch the latest data
        $.ajax({
            url: dataUrl,
            type: 'GET',
            dataType: 'json',
            success: function(weeklyData) {
                // Extract labels (days) and data values from the JSON data
                var labels = weeklyData.map(item => item.formatted_date); // Use the correct alias
                var data = weeklyData.map(item => item.total);

                // Get the chart context
                var ctx = chartCanvas.getContext('2d');

                // Create a new bar chart using Chart.js
                window.weeklyChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Weekly Report',
                            data: data,
                            backgroundColor: 'rgba(84, 93, 225, 0.711)', // Adjust color as needed
                            borderColor: 'rgb(84, 94, 225)', // Adjust color as needed
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            },
            error: function(error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    // Call the function initially to load the chart
    updateWeeklyChart();
</script>

<script>
    function updateWeeklyChartSales() {
        var chartCanvas = document.getElementById('weeklyChartSales');
        var dataUrl = chartCanvas.dataset.url;

        // Check if window.weeklyChartSales exists and is a valid Chart.js instance
        if (window.weeklyChartSales && window.weeklyChartSales.destroy) {
            window.weeklyChartSales.destroy();
        }

        // Make an AJAX request to fetch the latest data
        $.ajax({
            url: dataUrl,
            type: 'GET',
            dataType: 'json',
            success: function(weeklyData) {
                // Extract labels (days) and data values from the JSON data
                var labels = weeklyData.map(item => item.formatted_date); // Use the correct alias
                var data = weeklyData.map(item => item.total_amount);

                // Get the chart context
                var ctx = chartCanvas.getContext('2d');

                // Create a new bar chart using Chart.js
                window.weeklyChartSales = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Weekly Report',
                            data: data,
                            backgroundColor: 'rgba(84, 93, 225, 0.711)', // Adjust color as needed
                            borderColor: 'rgb(84, 94, 225)', // Adjust color as needed
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            },
            error: function(error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    // Call the function initially to load the chart
    updateWeeklyChartSales();
</script>


<script>
var student = <?php echo json_encode($orderData); ?>;
var xValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
new Chart("orderChart", {
    type: "bar",
    data: {
        labels: xValues,
        datasets: [{
            label: "Monthly Report",
            data: student,
            backgroundColor: 'rgba(84, 93, 225, 0.711)', // Adjust color as needed
            borderColor: 'rgb(84, 94, 225)', // Adjust color as needed
            fill: true,
            borderWidth: 1
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
// Call the function initially to load the chart
updateWeeklyChartSales();
var student = <?php echo json_encode($orderData); ?>;
var xValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
new Chart("orderChart", {
    type: "bar",
    data: {
        labels: xValues,
        datasets: [{
            label: "Monthly Report",
            data: student,
            backgroundColor: 'rgba(84, 93, 225, 0.711)', // Adjust color as needed
            borderColor: 'rgb(84, 94, 225)', // Adjust color as needed
            fill: true,
            borderWidth: 1
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
var student = <?php echo json_encode($salesData); ?>;
var xValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
new Chart("salesChart", {
    type: "bar",
    data: {
        labels: xValues,
        datasets: [{
            label: "Monthly Report",
            data: student,
            backgroundColor: 'rgba(84, 93, 225, 0.711)', // Adjust color as needed
            borderColor: 'rgb(84, 94, 225)', // Adjust color as needed
            fill: true,
            borderWidth: 1
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
$('#filterbutton').click(function() {
    var start_date = $("#start_date").val();
    var end_date = $("#end_date").val();
    var school_id = $("#school_id").val();


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
            url: '{{route("admin.school.filter.courseViewStudents.date")}}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                start_date: start_date,
                end_date: end_date,
                school_id: school_id,
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


<script>
$('#filterbutton1').click(function() {
    var start_date1 = $("#start_date1").val();
    var end_date1 = $("#end_date1").val();
    var school_id = $("#school_id").val();


    var startDateObj1 = new Date(start_date1);
    var endDateObj1 = new Date(end_date1);

    if (!start_date1 && !end_date1) {
        swal({
            icon: "error",
            title: 'Both Start Date and End Date are Empty',
            text: " ",

        });
    } else if (!start_date1 || !end_date1) {
        swal({
            icon: "error",
            title: 'Invalid Date Range There is an Empty Date',
            text: " ",

        });
    } else if ((startDateObj1 > endDateObj1) || (endDateObj1 < startDateObj1)) {
        swal({
            icon: "error",
            title: 'Invalid Date Range',
            text: " ",
        });
    } else {
        $.ajax({
            url: '{{route("admin.school.filter.reportsales.date")}}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                start_date: start_date1,
                end_date: end_date1,
                school_id: school_id,
            },
            success: function(response) {
                $('#filterresult1').html(response);

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