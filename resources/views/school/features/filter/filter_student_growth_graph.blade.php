@php
$total = 0;
foreach($studentData as $student){
$total+= $student;
}

$totalString = ($total <= 1) ? "Student" : "Students" ; @endphp <script>
    $(document).ready(function() {

    var year = <?php echo json_encode($year) ?>;
    var total = <?php echo json_encode($total) ?>;
    var studString = <?php echo json_encode($totalString) ?>;
    var fileTitle = ` Student Growth in ${year} : Total of ${total} ${studString}`;

    $('#table1').DataTable();
    });
    </script>






    <center>
        <h5 id><b>Student Growth in {{$year}} : Total of{{$total}} {{ $total <= 1 ? 'Student' : 'Students' }}</b>
        </h5>
    </center>


    <div class="row">
        <div class="col-12 mx-auto mt-3">

            <table id="table1" class="table" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Month</th>
                        <th>Number of Students</th>

                    </tr>
                </thead>
                <tbody>
                    @php $count = 1; @endphp
                    @foreach($studentData as $index => $numberOfstudents)
                    <tr>
                        <td>{{$count}}</td>
                        <td>{{ date("F", mktime(0, 0, 0, $count, 1)) }}</td>
                        <td>{{ $numberOfstudents }}</td>
                    </tr>
                    @php $count++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <center>
        <canvas id="studentChart1" style="width:100%;max-width:800px"></canvas>
    </center>


    <script>
        var student = <?php echo json_encode($studentData); ?>;
        var xValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        new Chart("studentChart1", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                    label: "No. of Student Drivers",
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