@include(SchoolFileHelper::$header, ['title' => 'Vehicle Management'])
<style>
    .btn-report {
        margin-top: 10px;
        padding: 10px 50px;
        height: 44px;
        background: var(--secondaryBG);
        color: white;
        border: none;
        text-align: center;
        outline: none;
        font-size: 16px;
        font-weight: 500;
        border-radius: 10px;
    }
</style>

<?php $statusString = $vehicle->status == 2 ? '<span class="waiting">Unavailable</span>' : '<span class="completed">Available</span>';
?>

<div class="container-fluid" style="padding: 20px;margin-top:60px">

    <div class="container px-4 mt-20">

        <div class="row gx-4">

            <div class="col-xl-4">

                <h6 style="margin-bottom:15px"><b>Status: </b>{!! $statusString !!}</h6>

                <div class="card border">

                    <center>
                        <h4><b>{{ $vehicle->name }}</b></h4>
                        Type <b>{{ $vehicle->type }}</b><br>

                        <img class="img-fluid" style="border-radius: 10px" src="/{{$vehicle->vehicle_img}}" alt="" srcset="">

                        <br>
                        <center>Plate Number: <b> {{$vehicle->plate_number }}</b></center>

                    </center>
                    <br>
                    <div class="row">

                        <div class="col-sm-12"><b>Manufacturer:</b> {{$vehicle-> manufacturer}}</div>
                        <div class="col-sm-12"><b>Model:</b> {{$vehicle-> model}}</div>
                        <div class="col-sm-12"><b>Year:</b> {{$vehicle-> year}}</div>
                        <div class="col-sm-12"><b>Transmission:</b> {{$vehicle-> transmission}}</div>
                        <div class="col-sm-12"><b>Fuel:</b> {{$vehicle-> fuel}}</div>
                        <div class="col-sm-12"><b>Color:</b> {{$vehicle-> color}}</div>

                        <br>
                        <a class="btn-report" href="/school/vehicle/view/Report/{{$vehicle_id}}/{{ $vehicle->name }}" role="button">View Report</a>                    </div>
                </div>

            </div>

            <div class="col-xl-8">
                <h6 style="margin-bottom:15px"><b>Vehicle Schedule</b></h6>
                <div class="card border">



                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">All</button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Incoming</button>
                            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Completed</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                            <!-- start all -->

                            @if(count($all))
                            <div class="card" style="margin: 10px 0 20px 0">
                                @php
                                $currentDate = null;
                                @endphp

                                @foreach($all as $sched)
                                @php
                                $startDate = \Carbon\Carbon::parse($sched->start_date)->format('D - F j, Y');
                                @endphp

                                @if($currentDate !== $startDate)
                                @if($currentDate !== null)
                            </div> <!-- Close the previous date div -->
                            @endif

                            <div class="date-tile" style="margin-bottom: 20px;">

                                <center>
                                    <h5><b>{{ $startDate }}</b></h5>

                                </center>
                                @endif

                                @php
                                $dateTimeString = $sched->start_date;
                                $dateTime = \Carbon\Carbon::parse($dateTimeString);
                                $formattedTime = $dateTime->format('h:i A');


                                $dateTimeString1 = $sched->end_date;
                                $dateTime1 = \Carbon\Carbon::parse($dateTimeString1);
                                $formattedTime1 = $dateTime1->format('h:i A');

                                $startTime = \Carbon\Carbon::parse($sched->start_date);
                                $endTime = \Carbon\Carbon::parse($sched->end_date);
                                $totalHours = $endTime->diffInHours($startTime);
                                @endphp

                                <b>{{ $formattedTime}} - {{ $formattedTime1}} </b>
                                <div class="card mb-3">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <b>Course: </b> {{$sched -> name}}<br>
                                            <b>Vehicle:</b> {{$sched -> vehicle_name}} <br>
                                            <b>Plate Number: </b> {{$sched -> plate_number}}<br>
                                            <b>Student: </b> {{$sched ->firstname}} {{$sched ->middlename}}
                                            {{$sched ->lastname}}
                                        </div>
                                        <div class="col-sm-4 text-end">
                                            <i class="fa-solid fa-stopwatch"></i> &nbsp; {{$totalHours}} hrs
                                        </div>
                                    </div>
                                </div>

                                @php
                                $currentDate = $startDate;
                                @endphp
                                @endforeach

                                @if($currentDate !== null)
                            </div> <!-- Close the last date div -->
                            @endif
                        </div>

                        @else

                        <div class="card" style="margin: 10px 0 20px 0">

                            <center>No Schedule Available</center>
                        </div>

                        @endif

                        <!-- end all -->


                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">


                        <!-- start incoming -->

                        @if(count($incoming))
                        <div class="card" style="margin: 10px 0 20px 0">
                            @php
                            $currentDate = null;
                            @endphp

                            @foreach($incoming as $sched)
                            @php
                            $startDate = \Carbon\Carbon::parse($sched->start_date)->format('D - F j, Y');
                            @endphp

                            @if($currentDate !== $startDate)
                            @if($currentDate !== null)
                        </div> <!-- Close the previous date div -->
                        @endif

                        <div class="date-tile" style="margin-bottom: 20px;">

                            <center>
                                <h5><b>{{ $startDate }}</b></h5>

                            </center>
                            @endif

                            @php
                            $dateTimeString = $sched->start_date;
                            $dateTime = \Carbon\Carbon::parse($dateTimeString);
                            $formattedTime = $dateTime->format('h:i A');


                            $dateTimeString1 = $sched->end_date;
                            $dateTime1 = \Carbon\Carbon::parse($dateTimeString1);
                            $formattedTime1 = $dateTime1->format('h:i A');

                            $startTime = \Carbon\Carbon::parse($sched->start_date);
                            $endTime = \Carbon\Carbon::parse($sched->end_date);
                            $totalHours = $endTime->diffInHours($startTime);
                            @endphp

                            <b>{{ $formattedTime}} - {{ $formattedTime1}} </b>
                            <div class="card mb-3">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <b>Course: </b> {{$sched -> name}}<br>
                                        <b>Vehicle:</b> {{$sched -> vehicle_name}} <br>
                                        <b>Plate Number: </b> {{$sched -> plate_number}}<br>
                                        <b>Student: </b> {{$sched ->firstname}} {{$sched ->middlename}}
                                        {{$sched ->lastname}}
                                    </div>
                                    <div class="col-sm-4 text-end">
                                        <i class="fa-solid fa-stopwatch"></i> &nbsp; {{$totalHours}} hrs
                                    </div>
                                </div>
                            </div>

                            @php
                            $currentDate = $startDate;
                            @endphp
                            @endforeach

                            @if($currentDate !== null)
                        </div> <!-- Close the last date div -->
                        @endif
                    </div>

                    @else

                    <div class="card" style="margin: 10px 0 20px 0">

                        <center>No Schedule Available</center>
                    </div>

                    @endif

                    <!-- end incoming -->



                </div>
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">


                    <!-- start completed-->

                    @if(count($completed))
                    <div class="card" style="margin: 10px 0 20px 0">
                        @php
                        $currentDate = null;
                        @endphp

                        @foreach($completed as $sched)
                        @php
                        $startDate = \Carbon\Carbon::parse($sched->start_date)->format('D - F j, Y');
                        @endphp

                        @if($currentDate !== $startDate)
                        @if($currentDate !== null)
                    </div> <!-- Close the previous date div -->
                    @endif

                    <div class="date-tile" style="margin-bottom: 20px;">

                        <center>
                            <h5><b>{{ $startDate }}</b></h5>

                        </center>
                        @endif

                        @php
                        $dateTimeString = $sched->start_date;
                        $dateTime = \Carbon\Carbon::parse($dateTimeString);
                        $formattedTime = $dateTime->format('h:i A');


                        $dateTimeString1 = $sched->end_date;
                        $dateTime1 = \Carbon\Carbon::parse($dateTimeString1);
                        $formattedTime1 = $dateTime1->format('h:i A');

                        $startTime = \Carbon\Carbon::parse($sched->start_date);
                        $endTime = \Carbon\Carbon::parse($sched->end_date);
                        $totalHours = $endTime->diffInHours($startTime);
                        @endphp

                        <b>{{ $formattedTime}} - {{ $formattedTime1}} </b>
                        <div class="card mb-3">
                            <div class="row">
                                <div class="col-sm-8">
                                    <b>Course: </b> {{$sched -> name}}<br>
                                    <b>Vehicle:</b> {{$sched -> vehicle_name}} <br>
                                    <b>Plate Number: </b> {{$sched -> plate_number}}<br>
                                    <b>Student: </b> {{$sched ->firstname}} {{$sched ->middlename}}
                                    {{$sched ->lastname}}
                                </div>
                                <div class="col-sm-4 text-end">
                                    <i class="fa-solid fa-stopwatch"></i> &nbsp; {{$totalHours}} hrs
                                </div>
                            </div>
                        </div>

                        @php
                        $currentDate = $startDate;
                        @endphp
                        @endforeach

                        @if($currentDate !== null)
                    </div> <!-- Close the last date div -->
                    @endif
                </div>

                @else

                <div class="card" style="margin: 10px 0 20px 0">

                    <center>No Schedule Available</center>
                </div>

                @endif

                <!-- end completed -->

            </div>
        </div>
    </div>


</div>

</div>
</div>

</div>




{{-- <script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('40178e8c6a9375e09f5c', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('test');
    channel.bind('test-event', function(data) {
        alert(JSON.stringify(data));
    });
</script> --}}
@include(SchoolFileHelper::$footer)