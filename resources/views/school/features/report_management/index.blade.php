@include(SchoolFileHelper::$header, ['title' => 'Report'])

<script>
    $(document).ready(function() {
        $('#table').DataTable();
        $('#table2').DataTable();
    });
</script>


<div class="container-fluid" style="padding: 20px;margin-top:60px">

    <div class="card border">

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
                    <b>ORDER</b></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                    <b>SALES</b></button>
            </li>


        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">

                <!-- dhjgfrehdwjhgfedwhsqjhgfdwhsqj -->
                <br>

                <div class="row row-cols-1 row-cols-lg-2 g-1 g-lg-3">
                    <div class="col">
                        <div class="card border">

                            <canvas id="weeklyChart" style="width:100%;max-width:700px" data-url="/school/reports/retreiveWeekly"></canvas>

                        </div>
                    </div>
                    <div class="col">
                        <div class="card border">

                            <canvas id="orderChart" style="width:100%;max-width:700px"></canvas>

                        </div>
                    </div>
                    <!-- <div class="col">
                        <div class="card border">

                            <canvas id="orderYear" style="width:100%;max-width:700px"></canvas>

                        </div>
                    </div> -->





                </div>





                <div class="card border mt-3">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-sm-2">
                                </div>

                                <div class="col-sm-4"><label for="">Start Date</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control mb-3" required>
                                </div>
                                <div class="col-sm-4"> <label for="">End Date</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control mb-3" required>
                                </div>
                                <div class="col-2">
                                    <center><br><button type="submit" id="filterbutton" class="btn btn-primary">Filter</button></center>
                                </div>
                            </div>
                            <div id="filterresult">
                                <div class="w-100 d-flex justify-content-between table-header-btn">
                                    <div class="d-flex" style="gap:15px">
                                        <a class="btn-outline-light" href="{{ route('course.total.order.export.pdf') }}"><i class="fa-solid fa-file-export"></i>Export
                                            PDF</a>
                                    </div>

                                </div>
                                <table id="table" class="table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Course</th>
                                            <th>Total Order</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($courses as $course)
                                        <tr>
                                            <td>{{ $course->name }}</td>
                                            <td>{{ $course->availed_service_count }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    </i>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item view-progress" href="/school/reports/course/viewStudents/{{ $course->id }}/{{ $course->name }}/{{ $start }}/{{ $end }}">View
                                                                Students</a></li>

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




            </div>
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                <br>

                <!-- start of sales -->


                <div class="row">
                    <div class="col-sm-2">
                    </div>

                    <div class="col-sm-4"><label for="">Start Date</label>
                        <input type="date" name="start_date1" id="start_date1" class="form-control mb-3" required>
                    </div>
                    <div class="col-sm-4"> <label for="">End Date</label>
                        <input type="date" name="end_date1" id="end_date1" class="form-control mb-3" required>
                    </div>
                    <div class="col-2">
                        <center><br><button type="submit" id="filterbutton1" class="btn btn-primary">Filter</button></center>
                    </div>
                </div>


                <div id="filterresult1">

                    <div class="w-100 d-flex justify-content-between table-header-btn">
                        <div class="d-flex" style="gap:15px">
                            <a class="btn-outline-light" href="{{ route('total.sales.export.pdf') }}"><i class="fa-solid fa-file-export"></i>Export
                                PDF</a>
                        </div>

                    </div>

                    <div class="row row-cols-1 row-cols-lg-2 g-1 g-lg-3">
                        <div class="col">
                            <div class="card border">

                                <canvas id="weeklyChartSales" style="width:100%;max-width:700px" data-url="/school/reports/retreiveWeeklySales"></canvas>

                            </div>
                        </div>
                        <div class="col">
                            <div class="card border">

                                <canvas id="salesChart" style="width:100%;max-width:700px"></canvas>

                            </div>
                        </div>
                        <!-- <div class="col">
                        <div class="card border">

                            <canvas id="salesYear" style="width:100%;max-width:700px"></canvas>

                        </div>
                    </div> -->

                    </div>

                </div>



                <!--                 
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
                                    <input type="date" name="end_date1" id="end_date1" class="form-control mb-3"
                                        required>
                                </div>
                                <div class="col-2">
                                    <center><br><button type="submit" id="filterbutton1"
                                            class="btn btn-primary">Filter</button></center>
                                </div>
                            </div>
                            <div id="filterresult1">
                                <div class="w-100 d-flex justify-content-between table-header-btn">
                                    <div class="d-flex" style="gap:15px">
                                        <a class="btn-outline-light"
                                            href="{{ route('course.total.sales.export.pdf') }}"><i class="fa-solid fa-file-export"></i>Export
                PDF</a>
            </div>

        </div>
        <table id="table2" class="table" style="width:100%">
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Total Order</th>
                    <th>Total Sales</th>
                    <th>Balance</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                @php $balance = $sale -> total_sales - $sale ->total_cash_payments; @endphp
                <tr>
                    <td>{{ $sale->name }}</td>
                    <td>{{ $sale->availed_service_count }}</td>
                    <td>{{ number_format($sale->total_sales, 2) }}</td>
                    <td>{{ number_format($balance, 2) }}</td>
                    <td>
                        <div class="dropdown">
                            <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            </i>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item view-progress" href="/school/reports/course/Sales/viewStudents/{{ $sale->id }}/{{ $sale->name }}/{{ $start }}/{{ $end }}">View
                                        Students</a></li>

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
</div> -->




                <!-- end of sales -->






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
    var student = <?php echo json_encode($orderYear); ?>;
    var xValues = ["2023", "2024", "2025", "2026", "2027", "2028", "2029", "2030"];
    new Chart("orderYear", {
        type: "bar",
        data: {
            labels: xValues,
            datasets: [{
                label: "Yearly Report",
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
    var student = <?php echo json_encode($salesYear); ?>;
    var xValues = ["2023", "2024", "2025", "2026", "2027", "2028", "2029", "2030"];
    new Chart("salesYear", {
        type: "bar",
        data: {
            labels: xValues,
            datasets: [{
                label: "Yearly Report",
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
                url: '{{ route('school.filter.courseViewStudents.date') }}',
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



<!-- <script>
    $('#filterbutton1').click(function() {
        var start_date1 = $("#start_date1").val();
        var end_date1 = $("#end_date1").val();


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
                url: '{{ route('school.filter.reportsales.date') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    start_date: start_date1,
                    end_date: end_date1,
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
</script> -->


<script>
    $('#filterbutton1').click(function() {
        var start_date1 = $("#start_date1").val();
        var end_date1 = $("#end_date1").val();


        var startDateObj1 = new Date(start_date1);
        var endDateObj1 = new Date(end_date1);

        ///revision
        var currentDate1 = new Date();
        currentDate1.setHours(0, 0, 0, 0);
        endDateObj1.setHours(0, 0, 0, 0);


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
        } else if (endDateObj1 > currentDate1) {
            ///revision
            swal({
                icon: "error",
                title: 'End Date should be equal to or less than the current date',
                text: " ",
            });
        } else {
            $.ajax({
                url: '{{ route('school.filter.salesReport.date') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    start_date: start_date1,
                    end_date: end_date1,
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


@include(SchoolFileHelper::$footer)