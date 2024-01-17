<script>
    $(document).ready(function() {
        $('#table1').DataTable();

    });
</script>


@php
$total = 0;
foreach($orderData as $order){
$total+= $order;
}

@endphp


<center>
    <h5 id><b>Order Growth in {{$year}} : Total of {{$total}} {{ $total <= 1 ? 'Order' : 'Orders' }}</b>
    </h5>
</center>


<center>
    <canvas id="orderChart1" style="width:100%;max-width:800px"></canvas>
</center>


<script>
    var orders = <?php echo json_encode($orderData); ?>;
    var xValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    new Chart("orderChart1", {
        type: "bar",
        data: {
            labels: xValues,
            datasets: [{
                label: "No. of Ordersss",
                data: orders,
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