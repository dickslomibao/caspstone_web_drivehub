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


<script>
    $(document).ready(function() {
        $('#table1').DataTable();
    });
</script>
<div class="w-100 d-flex justify-content-between table-header-btn">
    <div class="d-flex" style="gap:15px">
        <a class="btn-outline-light" href="/school/reports/course/filterTotalOrder/{{$start_date}}/{{$end_date}}/export_pdf"><i class="fa-solid fa-file-export"></i>Export
            PDF</a>
    </div>

</div>
<table id="table1" class="table" style="width:100%">
    <thead>
        <tr>
            <th>Course</th>
            <th>Total Order</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ( $courses as $course)
        <tr>
            <td>{{$course -> name}}</td>
            <td>{{$course -> availed_service_count}}</td>
            <td>
                <div class="dropdown">
                    <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    </i>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item view-progress" href="/school/reports/course/viewStudents/{{$course->id}}/{{$course->name}}/{{$start_date}}/{{$end_date}}">View
                                Students</a></li>

                    </ul>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>


<div class="col-12 mx-auto mt-3 mb-3">
    <div class="card rounded">
        <center>
            <h5 id="title"><b>Orders Made {{ $dateString}}</b>
            </h5>
        </center>



        <center>
            <canvas id="orderChartFilter" style="width:100%;"></canvas>
        </center>


    </div>
</div>

<script>
    //orderGraph 
    var orderData = <?php echo json_encode($orderData); ?>;

    var oLabel = orderData.map(entry => entry.day);
    var orderCounts = orderData.map(entry => entry.count_of_orders);

    new Chart("orderChartFilter", {
        type: "line",
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
</script>