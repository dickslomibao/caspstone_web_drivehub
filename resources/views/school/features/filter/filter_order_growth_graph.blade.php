@php
$total = 0;
foreach($orderData as $order){
$total+= $order;
}

$totalString = ($total <= 1) ? "Order" : "Orders" ; @endphp <script>
    $(document).ready(function() {

    var year = <?php echo json_encode($year) ?>;
    var total = <?php echo json_encode($total) ?>;
    var studString = <?php echo json_encode($totalString) ?>;
    var fileTitle = ` Order Growth in ${year} : Total of ${total} ${studString}`;

    $('#table1').DataTable();
    });
    </script>


    <center>
        <h5 id><b>Order Growth in {{$year}} : Total of {{$total}} {{ $total <= 1 ? 'Order' : 'Orders' }}</b>
        </h5>
    </center>


    <div class="row">
        <div class="col-12 mx-auto mt-3">

            <table id="table1" class="table" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Month</th>
                        <th>Number of Orders</th>

                    </tr>
                </thead>
                <tbody>
                    @php $count = 1; @endphp
                    @foreach($orderData as $index => $numberOfOrders)
                    <tr>
                        <td>{{$count}}</td>
                        <td> {{ date("F", mktime(0, 0, 0, $index + 1, 1)) }}</td>
                        <td>{{ $numberOfOrders }}</td>
                    </tr>
                    @php $count++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

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
                    label: "No. of Orders",
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