<div class="col-11 mx-auto p-2">
    <div class="p-3 border bg-light" id="box1">
        <canvas id="orderChart1" style="width:100%;max-width:600px"></canvas>


    </div>
</div>
<div class="col-11 mx-auto p-2">
    <div class="p-3 border bg-light" id="box1">
        <canvas id="completionChart1" style="width:100%;max-width:600px"></canvas>

    </div>
</div>




<script>
    var school = <?php echo json_encode($services); ?>;
    var xValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    new Chart("orderChart1", {
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


    new Chart("completionChart1", {
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