<div class="col-11 mx-auto p-2">
    <div class="p-3 border bg-light" id="box1">
        <canvas id="studentChart1" style="width:100%;max-width:600px"></canvas>
    </div>
</div>

<script>
    var studentNo = <?php echo json_encode($studentGraph); ?>;
    var xValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    new Chart("studentChart1", {
        type: "line",
        data: {
            labels: xValues,
            datasets: [{
                label: "No. of Student",
                data: studentNo,
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