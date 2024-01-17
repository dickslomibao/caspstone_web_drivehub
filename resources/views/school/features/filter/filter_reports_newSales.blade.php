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


<div class="w-100 d-flex justify-content-between table-header-btn">
    <div class="d-flex" style="gap:15px">
        <a class="btn-outline-light" href="/school/reports/filter/total/sales/{{$start_date}}/{{$end_date}}/export_pdf"><i class="fa-solid fa-file-export"></i>Export
            PDF</a>
    </div>

</div>

<div class="col-12 mx-auto mt-3 mb-3">
    <div class="card rounded">
        <center>
            <h5 id="title"><b>Sales Made {{ $dateString}}</b>
            </h5>
        </center>



        <center>
            <canvas id="revenueChartFilter" style="width:100%;"></canvas>
        </center>


    </div>
</div>


<script>
    $(document).ready(function() {






        //revenueGraph
        var revenueData = <?php echo json_encode($revenueData); ?>;

        var rLabel = revenueData.map(entry => entry.day);
        var totalRev = revenueData.map(entry => entry.total_revenue);

        new Chart("revenueChartFilter", {
            type: "bar",
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