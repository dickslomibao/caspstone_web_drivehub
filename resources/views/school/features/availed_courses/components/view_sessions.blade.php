@if ($availed->session != 0)
    @php
        $last = -1;
    @endphp
    <div class="row">
        @foreach ($sessions as $session)
            <div class="col-lg-6">
                <div class="session-box card">
                    <div class="d-flex align-items-center justify-content-between" style="">
                        <h6>Session {{ $session->session_number }}</h6>
                        @php
                            $schedule = $schedules->getScheduleInfoWithId($session->schedule_id);
                        @endphp
                        {{-- <div class="dropdown">
                            <span style="cursor: pointer" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false"><i class="fas fa-ellipsis-v"></i></span>
                            <ul class="dropdown-menu">
                                @if (($last == -1 || $last != 0) && $session->schedule_id == 0)
                                    @if ($availed->type == 1)
                                        <li> <a class="dropdown-item"
                                                href="{{ route('create.practicalschedule', [
                                                    'oderlist_id' => $availed->id,
                                                    'session_id' => $session->id,
                                                ]) }}"
                                                class="">Set schedules</a></li>
                                        @else
                                                    <li><a href="" class="dropdown-item">Select schedules</a>
                                                    </li>
                                    @endif
                                @endif
                              
                                @if ($session->schedule_id != 0 && $schedule->type == 2)
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('theoritical.view', [
                                                                'id' => $t->id,
                                                                
                                                            ]) }}">View
                                                            Schedules</a>
                                                    </li>
                                                @endif
                                @if ($session->schedule_id != 0)
                                    @if ($schedule->status == 1)
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('update.practical', [
                                                    'order_list_id' => $availed->id,
                                                    'session_id' => $session->id,
                                                ]) }}">Update
                                                schedule</a>
                                        </li>
                                    @endif
                                @endif
                                @if ($session->schedule_id != 0 && $schedule->type == 1)
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('update.practical', [
                                                            'order_list_id' => $availed->id,
                                                            'session_id' => $session->id,
                                                        ]) }}">View
                                                        Live Tracking</a>
                                                </li>
                                            @endif
                                @if ($session->session_number == $availed->session && $session->session_number != 1 && $session->schedule_id == 0)
                                    <li class="">
                                        <a style="cursor: pointer"
                                            onclick="r= confirm('Are you sure you want to remove the session ?');if(r==true){location.href='/availed/courses/{{ $availed->id }}/view/{{ $session->id }}/removesession';}"
                                            class="dropdown-item">Remove session</a>
                                    </li>
                                @endif
                            </ul>
                        </div> --}}
                    </div>
                    @if ($session->schedule_id == 0)
                        <h6 style="margin-top: 20px">Waiting for schedules</h6>
                    @else
                        @if ($schedule->type == 1)
                            <div class="row">
                                <div class="col-12">

                                    @switch($schedule->status)
                                        @case(1)
                                            <div style="margin:10px 0 20px 0">
                                                <span class="waiting">
                                                    Waiting</span>
                                            </div>
                                        @break

                                        @case(2)
                                            <div style="margin:10px 0 20px 0">
                                                <span class="started">
                                                    Started</span>
                                            </div>
                                        @break

                                        @case(3)
                                            <div style="margin:10px 0 20px 0">
                                                <span class="completed">
                                                    Completed</span>
                                            </div>
                                        @break

                                        @default
                                    @endswitch

                                    <h6 style="margin-top: 10px">Date:
                                        {{ date_format(date_create($schedule->start_date), 'D - F d, Y') }}
                                    </h6>
                                    <h6 style="margin-top: 5px">Time:
                                        {{ date_format(date_create($schedule->start_date), 'h:i A') }}
                                        -
                                        {{ date_format(date_create($schedule->end_date), 'h:i A') }}
                                    </h6>
                                    @foreach ($scheduleInstructorRepository->getSchedulesInstructor($schedule->id) as $instructor)
                                        <h6 style="margin-top: 10px">
                                            Instructor:
                                            {{ $instructor->firstname }} {{ $instructor->lastname }}
                                        </h6>
                                    @endforeach
                                    @php
                                        $vehicle = $scheduleVehicleRepository->getScheduleVehicle($schedule->id);
                                    @endphp
                                    <h6 style="margin-top: 5px">Vehicle: {{ $vehicle->name }}
                                        ({{ $vehicle->transmission }})
                                    </h6>
                                </div>
                            </div>
                        @else
                            @php

                                $t = $theoritical->getTheoriticalWithScheduleId($schedule->id);
                            @endphp
                            <div class="row">
                                <div class="col-12">

                                    @switch($schedule->status)
                                        @case(1)
                                            <div style="margin:10px 0 20px 0">
                                                <span class="waiting">
                                                    Waiting</span>
                                            </div>
                                        @break

                                        @case(2)
                                            <div style="margin:10px 0 20px 0">
                                                <span class="started">
                                                    Started</span>
                                            </div>
                                        @break

                                        @case(3)
                                            <div style="margin:10px 0 20px 0">
                                                <span class="completed">
                                                    Completed</span>
                                            </div>
                                        @break

                                        @default
                                    @endswitch
                                    <h6 style="margin-top: 10px">Title:
                                        {{ $t->title }}
                                    </h6>
                                    <h6 style="margin-top: 10px">Date:
                                        {{ date_format(date_create($schedule->start_date), 'D - F d, Y') }}
                                    </h6>
                                    <h6 style="margin-top: 5px">Time:
                                        {{ date_format(date_create($schedule->start_date), 'h:i A') }}
                                        -
                                        {{ date_format(date_create($schedule->end_date), 'h:i A') }}
                                    </h6>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            @php
                $last = $session->schedule_id;
            @endphp
        @endforeach
    </div>
@endif
