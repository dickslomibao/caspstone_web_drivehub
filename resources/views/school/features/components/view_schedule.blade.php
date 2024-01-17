@php
use Carbon\Carbon;
@endphp
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h6>Status: @switch($schedule->status)
                @case(1)
                Waiting
                @break

                @case(2)
                Started
                @break

                @case(3)
                Completed
                @break

                @default
                @endswitch
            </h6>
            <h6 style="margin-top:10px">Start Date: {{ Carbon::parse($schedule->start_date)->format('M d, Y h:i a') }}
            </h6>
            <h6>End Date: {{ Carbon::parse($schedule->end_date)->format('M d, Y h:i a') }}</h6>
            @if ($schedule->type == 1)
            <h6 style="margin-top:10px">Course:</h6>
            <h6 style="">Name: {{ $schedule->course_name }}</h6>
            <h6 style="">Duration: {{ $schedule->course_duration }} hrs</h6>
            <div class="card" style="margin: 20px 0">
                <div class="row">
                    <div class="col-lg-6">
                        <h6 style="margin-top:10px">Student:</h6>
                        @foreach ($schedule->students as $student)
                        <div class="d-flex align-items-center" style="margin: 10px 0;column-gap:10px">
                            <img src="/{{ $student->profile_image }}" alt="" style="width: 40px;height:40px;object-fit:cover;border-radius:50%">
                            <div>
                                <h6 style="font-weight: 500">
                                    {{ $student->firstname }} {{ $student->lastname }}
                                </h6>
                                <p style="font-size: 14px;font-weight:500">
                                    {{ $student->email }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="col-lg-6">
                        <h6 style="margin-top:10px">Instructor:</h6>
                        @foreach ($schedule->instructors as $ins)
                        <div class="d-flex align-items-center" style="margin: 10px 0;column-gap:10px">
                            <img src="/{{ $ins->profile_image }}" alt="" style="width: 40px;height:40px;object-fit:cover;border-radius:50%">
                            <div>
                                <h6 style="font-weight: 500">
                                    {{ $ins->firstname }} {{ $ins->lastname }}
                                </h6>
                                <p style="font-size: 14px;font-weight:500">
                                    {{ $ins->email }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card border-primary mb-2">
                <div class="card-header bg-transparent border-primary">
                    <h6>Vehicle:</h6>
                </div>
                <div class="card-body text-dark">
                    <h6 style="margin-top:5px">Name:{{ $schedule->vehicle->name }}</h6>
                    <h6 style="">Tranmission: {{ $schedule->vehicle->transmission }}</h6>
                    <h6 style="">Model: {{ $schedule->vehicle->model }}</h6>
                </div>
            </div>

            <div class="card border-success mb-2">
                <div class="card-header bg-transparent border-success">
                    <h6>Mileage used:</h6>
                </div>
                <div class="card-body text-dark">
                    @foreach ($schedule->mileage as $mileage)
                    @if ($mileage->code == 1)
                    <h6 style="margin-top:5px">Starting mileage: {{ $mileage->mileage }}</h6>
                    @else
                    <h6 style="margin-top:5px">Ending mileage: {{ $mileage->mileage }}</h6>
                    @endif
                    @endforeach
                </div>
            </div>


            @else
            <div class="card mb-3">
                <h6 style="margin-top: 10px">Theoritical</h6>
                <h6>Title: {{ $schedule->theoritical->title }}</h6>
                <h6>Slots: {{ $schedule->theoritical->slot }}</h6>

                <h6 style="margin-top:10px">Instructor:</h6>
                <div class="row">
                    @foreach ($schedule->instructors as $ins)
                    <div class="col-lg-6">
                        <div class="d-flex align-items-center" style="margin: 10px 0;column-gap:10px">
                            <img src="/{{ $ins->profile_image }}" alt="" style="width: 40px;height:40px;object-fit:cover;border-radius:50%">
                            <div>
                                <h6 style="font-weight: 500">
                                    {{ $ins->firstname }} {{ $ins->lastname }}
                                </h6>
                                <p style="font-size: 14px;font-weight:500">
                                    {{ $ins->email }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="card">
                <h6 style="margin-top:0">Students:</h6>
                <div class="row">
                    @foreach ($schedule->students as $student)
                    <div class="col-lg-6">
                        <div class="d-flex align-items-center" style="margin: 10px 0;column-gap:10px">
                            <img src="/{{ $student->profile_image }}" alt="" style="width: 40px;height:40px;object-fit:cover;border-radius:50%">
                            <div>
                                <h6 style="font-weight: 500">
                                    {{ $student->firstname }} {{ $student->lastname }}
                                </h6>
                                <p style="font-size: 14px;font-weight:500">
                                    {{ $student->email }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if ($schedule->status != 1)
            <div class="card border-dark mb-2">
                <div class="card-header bg-transparent border-dark">
                    <h6>Logs:</h6>
                </div>
                <div class="card-body text-dark">
                    @foreach ($schedule->logs as $logs)
                    @if ($logs->type == 1)
                    <h6>Date Started: {{ Carbon::parse($logs->date_process)->format('M d, Y h:i a') }}</h6>
                    @endif
                    @if ($logs->type == 2)
                    <h6>Date Ended: {{ Carbon::parse($logs->date_process)->format('M d, Y h:i a') }}</h6>
                    @endif
                    @endforeach
                </div>
            </div>
            @endif


        </div>
    </div>
</div>