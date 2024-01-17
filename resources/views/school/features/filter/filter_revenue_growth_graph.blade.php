@php
$total = 0;
foreach($revenueData as $revenue){
$total += $revenue;
}


@endphp


<script>
// $(document).ready(function() {

//     var year = <?php echo json_encode($year) ?>;
//     var total = <?php echo json_encode(number_format($total, 2)) ?>;
//     var fileTitle = `${year} Revenue: Total of Php. ${total}`;

//     $('#table1').DataTable();
// });
// </script>

<center>
    <h5><b> {{$year}} Revenue: Total of Php. {{number_format($total, 2)}}
        </b>
    </h5>
</center>
<div class="row">
    <div class="col-12 mx-auto mt-3">
        <table id="table1" class="table" style="width:100%">
            <thead>
                <tr>
                    <th></th>
                    <th>Month</th>
                    <th>Revenue for the Month</th>
                </tr>
            </thead>
            <tbody>
                @php $count = 1; @endphp
                @foreach($revenueData as $index => $revenue)
                <tr>
                    <td>{{$count}}</td>
                    <td>{{ date("F", mktime(0, 0, 0, $count, 1)) }}</td>
                    <td>{{$revenue }}</td>
                </tr>
                @php $count++; @endphp
                @endforeach
            </tbody>
        </table>
    </div>

</div>
<center>
    <canvas id="revenueChart1" style="width:100%;max-width:800px"></canvas>
</center>


<script>
var revenue = <?php echo json_encode($revenueData); ?>;
var xValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
new Chart("revenueChart1", {
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