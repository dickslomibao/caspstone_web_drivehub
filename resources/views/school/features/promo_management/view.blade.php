@include(SchoolFileHelper::$header, ['title' => 'Promo details'])
<style>
.btn-add-promo {
    margin-top: 10px;
    width: 100%;
    height: 38px;
    background: var(--secondaryBG);
    color: white;
    border: none;
    outline: none;
    font-size: 15px;
    font-weight: 500;
    border-radius: 10px;
}
</style>



@php
$currentYear = date('Y');
$currentMonth = date('F');
$lastMonth = date('F', strtotime('-1 month'));




$total = 0;
foreach($orderData as $order){
$total+= $order;
}


@endphp

<div class="container-fluid" style="padding: 20px;margin-top:60px">




        <div class="row">

            <div class="col-lg-4">


                <div class="card">
                 
                        <h6>Promo Title: {{ $promo->name }}</h6>

                        <h6 style="margin:10px 0;">
                            Available from
                            <b> {{ \Carbon\Carbon::parse($promo->start_date)->format('F j, Y')}}</b> to <br>
                            <b> {{ \Carbon\Carbon::parse($promo->end_date)->format('F j, Y')}}</b>
                        </h6>

                        <img class="img-fluid" style="border-radius: 10px" src="/{{($promo->thumbnail)}}" alt=""
                            srcset="">

                 
                    <br>

                    <div style="text-align: justify;">
                        <h6> Description: {{ $promo->description }}</h6>
                        <h6 style="margin-top: 5px">Price: Php {{ number_format($promo->price, 2, '.', ',') }} </p>
                    </div>


                </div>
                <br>


            </div>

            <div class="col-lg-8">
                <div class="">

                    <h6 style="margin-bottom: 10px">Promo Items</h6>


                    <div class="row">
                        
                        @php
                        if($datarow == "None"){
                        @endphp
                        <center>
                            <h5>Promo Items</h5>
                        </center>
                        @php
                        }else{
                        @endphp
                        @foreach ($courses as $course)

                        <div class="card col-md-6 " onclick="">
                            <img class="img-fluid" src="/{{($course->thumbnail) }}" alt="Thumbnail">
                            <div class="coursename"> {{$course->name}} 
                                @php if($course->status==2){
                                    echo " is
                                UNAVAILABLE";
                            } @endphp</div>
                            <div class="coursedesc"> <b>Course Description: </b> {{ $course->description}}
                                <br><b>Duration: </b> {{ $course->duration}} Hours
                                <p>Price <b>{{ number_format($course->price, 0, '.', ',') }}</b></p>
                            </div>

                        </div>

                        @endforeach
                        @php
                        }
                        @endphp

                    </div>
                </div>
                <!-- table partttttttttttttttttttttttt -->

            </div>

        </div>

    <div class="card border mt-5">

        <center>
            <h5 id="title"><b> Order Growth in {{$currentYear}} : Total of {{$total}}
                    {{ $total <= 1 ? 'Order' : 'Orders' }}
                </b>
            </h5>
        </center>


        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-sm-5"> <label for="">Filter Year</label>
                        <input type="hidden" name="promo_id" id="promo_id" value="{{$promo_id}}"
                            class="form-control mb-3" max="4" required>

                        <input type="number" name="year" id="year" value="{{$currentYear}}"
                            class="form-control mb-3" max="4" required>
                    </div>
                    <div class="col-sm-3"><label for=""></label>
                        <br>
                        <button type="submit" id="filterbutton" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </div>
        </div>


        <div id="filterresult">
            <center>
                <canvas id="orderChart" style="width:100%;max-width:800px"></canvas>
            </center>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {




    $('#filterbutton').click(function() {

        var year = $('#year').val();
        var promo_id = $('#promo_id').val();

        $.ajax({
            url: '{{route("promo.filter.OrderGraph") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                year: year,
                promo_id: promo_id
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
var orders = <?php echo json_encode($orderData); ?>;
var xValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
new Chart("orderChart", {
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

@include(SchoolFileHelper::$footer)