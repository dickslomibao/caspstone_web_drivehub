@include(SchoolFileHelper::$header, ['title' => 'Filter Revenue Yearly'])


@php
    $currentYear = date('Y');
    $currentMonth = date('F');
    $lastMonth = date('F', strtotime('-1 month'));

    $total = 0;
    foreach ($revenueData as $revenue) {
        $total += $revenue;
    }

@endphp
{{-- <script>
    $(document).ready(function() {

        var currentYear = <?php echo json_encode($currentYear); ?>;
        var total = <?php echo json_encode(number_format($total, 2)); ?>;
        var fileTitle = "${currentYear} Revenue: Total of Php. ${total}";

        $('#table').DataTable();
    });
</script> --}}
<div class="container-fluid" style="padding: 20px;margin-top:60px">
    <div class="col-12 mx-auto">
        <div class="card">
            <center>
                <h5 id="title"><b> <span id="taon">{{ $currentYear }} </span> Revenue: Total of Php.
                        {{ number_format($total, 2) }}
                    </b>
                </h5>
            </center>


            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="mb-3">
                            <label for="">Filter Year</label>
                            <input type="number" name="year" id="year" value="{{ $currentYear }}"
                                class="form-control w-100" max="4" required>
                        </div>

                        <button type="submit" id="filterbutton" style="background: var(--primaryBG)"
                            class="btn btn-primary">Filter</button>
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
                                    <th>Revenue for the Month</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php $count = 1; @endphp
                                @foreach ($revenueData as $index => $revenue)
                                    <tr>
                                        <td>{{ $count }}</td>
                                        <td>{{ date('F', mktime(0, 0, 0, $count, 1)) }}</td>
                                        <td>{{ $revenue }}</td>
                                    </tr>
                                    @php $count++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                <center>
                    <canvas id="revenueChart" style="width:100%"></canvas>
                </center>
            </div>

        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        $('#filterbutton').click(function() {

            var year = $('#year').val();
            //$('#taon').text(year);

            $.ajax({
                url: '{{ route('school.filter.RevenueGrowthGraph') }}',
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
    var revenue = <?php echo json_encode($revenueData); ?>;
    var xValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    new Chart("revenueChart", {
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
@include(SchoolFileHelper::$footer)
