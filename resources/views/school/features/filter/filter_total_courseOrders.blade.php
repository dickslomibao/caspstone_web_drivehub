<script>
    $(document).ready(function() {
        $('#table1').DataTable();
    });
</script>

@php
$total = 0;
foreach($coursesData as $courses){
$total += $courses;
}

@endphp





<center>
    <h5><b> Total Course Orders Made in {{$year}}: {{$total}}
        </b>
    </h5>
</center>

<center>
    <canvas id="coursesChart1" style="width:100%;max-width:800px"></canvas>
</center>


<script>
    var revenue = <?php echo json_encode($coursesData); ?>;
    var xValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    new Chart("coursesChart1", {
        type: "line",
        data: {
            labels: xValues,
            datasets: [{
                label: "Revenue",
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