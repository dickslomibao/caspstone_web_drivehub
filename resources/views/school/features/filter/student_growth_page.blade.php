@include(SchoolFileHelper::$header, ['title' => 'Filter Student Yearly'])


@php
$currentYear = date('Y');
$currentMonth = date('F');
$lastMonth = date('F', strtotime('-1 month'));

$total = 0;
foreach ($studentData as $student) {
$total += $student;
}

$totalString = ($total <= 1) ? "Student" : "Students" ; @endphp <script>
    $(document).ready(function() {

    var year = <?php echo json_encode($currentYear) ?>;
    var total = <?php echo json_encode($total) ?>;
    var studString = <?php echo json_encode($totalString) ?>;
    var fileTitle = ` Student Growth in ${year} : Total of ${total} ${studString}`;

    $('#table').DataTable();
    });
    </script>



    <div class="container-fluid" style="padding: 20px;margin-top:60px">
        <div class="col-10 mx-auto">
            <div class="card border">
                <center>
                    <h5 id="title"><b> Student Growth in {{$currentYear}} : Total of {{$total}}
                            {{ $total <= 1 ? 'Student' : 'Students' }}
                        </b>
                    </h5>
                </center>


                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-sm-5"> <label for="">Filter Year</label>
                                <input type="number" name="year" id="year" value="{{$currentYear}}" class="form-control mb-3" max="4" required>
                            </div>
                            <div class="col-sm-3"><label for=""></label>
                                <br>
                                <button type="submit" id="filterbutton" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div id="filterresult">
                    <div class="row">
                        <div class="col-12 mx-auto">

                            <table id="table" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Month</th>
                                        <th>No. of Students</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count = 1; @endphp
                                    @foreach($studentData as $index => $student)
                                    <tr>
                                        <td>{{$count}}</td>
                                        <td>{{ date("F", mktime(0, 0, 0, $count, 1)) }}</td>
                                        <td>{{$student }}</td>
                                    </tr>
                                    @php $count++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <center>
                        <canvas id="revenueChart" style="width:100%;max-width:800px"></canvas>
                    </center>
                </div>

            </div>
        </div>

    </div>








    <script>
        $(document).ready(function() {




            $('#filterbutton').click(function() {

                var year = $('#year').val();

                $.ajax({
                    url: '{{route("school.filter.studentGrowthGraph") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        year: year,
                    },
                    success: function(response) {
                        $('#filterresult').html(response);
                        $('#title').hide();
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
        var revenue = <?php echo json_encode($studentData); ?>;
        var xValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        new Chart("revenueChart", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                    label: "No. of Students",
                    data: revenue,
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
    @include(SchoolFileHelper::$footer)