@include(SchoolFileHelper::$header, ['title' => 'Availed course'])
<style>
    .btn-view {
        background-color: var(--secondaryBG);
        color: white;
        padding: 8px 20px;
        border-radius: 5px;
        border: none;
        outline: none;
        font-size: 15px;

    }

    .btn-text,
    .btn-text:hover {
        color: var(--secondaryBG);
        font-size: 16px;
    }

    .session-box {
        margin-top: 20px;
        padding: 20px;
        box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
    }

    .line-sched {
        border-bottom: 2px solid var(--borderColor);
        flex: auto;
    }

    .waiting {
        background: #9d9d9d;
        color: white;
        padding: 5px 10px;
        border-radius: 10px;
        font-size: 12px;
    }

    .started {
        background: var(--primaryBG);
        color: white;
        padding: 5px 10px;
        border-radius: 10px;
        font-size: 12px;
    }

    .completed {
        background: var(--forestgreen);
        color: white;
        padding: 5px 10px;
        border-radius: 10px;
        font-size: 12px;
    }
</style>
<div class="container-fluid" style="padding: 20px;margin-top:60px;">
    <div class="row">
        <div class="col-12">
            <div style="margin-bottom: 20px" class="d-flex align-items-center justify-content-between">
                @switch($availed->status)
                    @case(1)
                        <div>
                            <h5 style="margin-bottom: 5px">
                                Status: Waiting for session
                            </h5>
                            <h6>Remarks: {{ $availed->remarks }} </h6>
                        </div>
                    @break

                    @case(2)
                        <div>
                            <h5 style="margin-bottom: 5px">
                                Status: Course Ongoing
                            </h5>
                            <h6>Remarks: {{ $availed->remarks }} </h6>
                        </div>
                    @break

                    @case(3)
                        <div>
                            <h5 style="margin-bottom: 5px">
                                Status: Completed
                            </h5>
                            <h6>Remarks: {{ $availed->remarks }} </h6>
                        </div>
                    @break

                    @default
                @endswitch
                <div>
                    {{-- <i class="fa-sharp fa-solid fa-gear" style="font-size: 20px;margin-right:10px"></i> --}}
                    <i class="far fa-comments-alt" onclick="messageWithUser('{{ $availed->student_id }}');"
                        style="font-size: 20px"></i>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <h6>Student Information</h6>
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center" style="margin: 20px 0;column-gap:10px">
                    <img src="/{{ $availed->profile_image }}" alt=""
                        style="width: 40px;height:40px;object-fit:cover;border-radius:50%">
                    <div>
                        <h6 style="font-weight: 500">
                            {{ $availed->firstname }} {{ $availed->lastname }}
                        </h6>
                        <p style="font-size: 14px;font-weight:500">
                            {{ $availed->email }}
                        </p>
                    </div>
                </div>

                {{-- <a href="{{ route('progress.availedcourse', [
                    'id' => 2,
                ]) }}"
                    class="btn-text">View Mock exam Progress</a> --}}
                @if ($availed->type == 2)
                    <a role="button" class="btn-text" data-bs-toggle="modal" data-bs-target="#mockexam">View
                        Mock Exam</a>
                @else
                    <a role="button" class="btn-text" data-bs-toggle="modal" data-bs-target="#progress">View
                        Progress</a>
                @endif


            </div>
            @php

            @endphp
            <h6>Course Information</h6>
            <div class="d-flex align-items-center justify-content-between">
                <div style="column-gap:10px;margin-top:20px" class="d-flex align-items-top">
                    <img src="/{{ $availed->thumbnail }}" alt=""
                        style="width: 120px;height:120px;object-fit:cover;border-radius:10px">
                    <div>
                        <h6 style="margin-bottom: 5px">Course name: {{ $availed->name }}</h6>
                        <h6 style="margin-bottom: 5px">Course price: {{ number_format($availed->price, 2) }}</h6>
                        <h6 style="margin-bottom: 5px">Duration:{{ $availed->duration }} hrs</h6>
                        <h6 style="margin-bottom: 5px">Total completed
                            hours:{{ $completed_hours > $availed->duration ? $availed->duration : $completed_hours }}
                            hrs</h6>

                        <h6 style="margin-bottom: 5px">Remaining
                            hours:{{ $availed->duration - $completed_hours }}
                            hrs</h6>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center" style="margin-top: 20px;column-gap:10px">
                <a href="{{ route('view.order', [
                    'id' => $availed->order_id,
                ]) }}"
                    class="btn-text">View order</a>
                @if ($availed->session == 0)
                    <button class="btn-view" data-bs-toggle="modal" data-bs-target="#makeSession">Make a
                        session</button>
                @else
                    @if ($completed_hours >= $availed->duration)
                        @if ($availed->status != 3)
                            <button class="btn-view" data-bs-toggle="modal" data-bs-target="#remarksModal">Set
                                as completed</button>
                        @endif
                    @else
                        @if ($availed->duration > $total_assign_hours)
                            <button class="btn-view"
                                onclick="r= confirm('Are you sure you want to add session ?');if(r==true){location.href='/availed/courses/{{ $availed->id }}/view/addsession';} ">Add
                                session</button>
                        @endif

                    @endif
                @endif
            </div>
            @if ($availed->session != 0)
                @php
                    $last = -1;
                @endphp
                <div class="d-flex align-items-center justify-content-between" style="column-gap:10px;margin-top:20px">
                    <div class="line-sched">
                    </div>
                    <h5>Schedules</h5>

                    <div class="line-sched">
                    </div>
                </div>
                <div class="row">
                    @foreach ($sessions as $session)
                        <div class="col-lg-4">
                            <div class="session-box">
                                <div class="d-flex align-items-center justify-content-between" style="">
                                    <h6>Session {{ $session->session_number }}</h6>
                                    <div class="dropdown">
                                        <span style="cursor: pointer" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false"><i class="fas fa-ellipsis-v"></i></span>
                                        <ul class="dropdown-menu">

                                            @if ($session->schedule_id != 0)
                                                <li> <a class="dropdown-item"
                                                        onClick="showSched({{ $session->schedule_id }})"
                                                        role="button">
                                                        View Schedule
                                                    </a>
                                                </li>
                                                {{-- @else
                                                <li><a href="" class="dropdown-item">Select schedules</a>
                                                </li> --}}
                                            @endif

                                            @if (($last == -1 || $last != 0) && $session->schedule_id == 0)
                                                @if ($availed->type == 1)
                                                    <li> <a class="dropdown-item"
                                                            href="{{ route('create.practicalschedule', [
                                                                'oderlist_id' => $availed->id,
                                                                'session_id' => $session->id,
                                                            ]) }}"
                                                            class="">Set schedules</a></li>
                                                    {{-- @else
                                                    <li><a href="" class="dropdown-item">Select schedules</a>
                                                    </li> --}}
                                                @endif
                                            @endif
                                            @php
                                                $schedule = $schedules->getScheduleInfoWithId($session->schedule_id);
                                            @endphp
                                            {{-- @if ($session->schedule_id != 0 && $schedule->type == 2)
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('theoritical.view', [
                                                                'id' => $t->id,
                                                                
                                                            ]) }}">View
                                                            Schedules</a>
                                                    </li>
                                                @endif --}}
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
                                            {{-- @if ($session->schedule_id != 0 && $schedule->type == 1)
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('update.practical', [
                                                            'order_list_id' => $availed->id,
                                                            'session_id' => $session->id,
                                                        ]) }}">View
                                                        Live Tracking</a>
                                                </li>
                                            @endif --}}
                                            @if ($session->session_number == $availed->session && $session->session_number != 1 && $session->schedule_id == 0)
                                                <li class="">
                                                    <a style="cursor: pointer"
                                                        onclick="r= confirm('Are you sure you want to remove the session ?');if(r==true){location.href='/availed/courses/{{ $availed->id }}/view/{{ $session->id }}/removesession';}"
                                                        class="dropdown-item">Remove session</a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
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
        </div>
    </div>
</div>


@php
    $not_checked = 0;
@endphp
@if ($availed->type == 1)
    <div class="modal fade modal-lg" id="progress" tabindex="-1" aria-labelledby="makeSessionLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 style="margin-bottom: 20px">Student Progress</h5>
                    <div class="row">
                        @foreach ($progress as $prog)
                            <div class="col-lg-6">
                                <h6 style="">{{ $prog->progress->title }}</h6>
                                <div class="card" style="margin: 20px 0">
                                    @foreach ($prog->sub_progress as $sub)
                                        @if ($sub->status == 1)
                                            @php
                                                $not_checked++;
                                            @endphp
                                        @endif
                                        <div class="d-flex align-items-center" style="gap: 10px">
                                            <input type="checkbox" readonly {{ $sub->status == 2 ? 'checked' : '' }}>
                                            <h6>{{ $sub->title }}</h6>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if ($not_checked > 0)
                        <div class="row">
                            <div class="col-12">
                                <form
                                    action="{{ route('checkallprogress.availedcourse', [
                                        'id' => $availed->id,
                                    ]) }}"
                                    method="post">
                                    @csrf
                                    <div class="d-flex align-items-center justify-content-end">
                                        <button class="btn-add" type="submit">Check all</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif

@if ($availed->type == 2)
    <div class="modal fade modal-lg" id="mockexam" tabindex="-1" aria-labelledby="makeSessionLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 style="margin-bottom: 20px">Student Mock Exam</h5>

                    <div class="row">
                        @foreach ($mock_list as $m)
                            <div class="col-lg-6" style="margin-top: 10px">
                                <div class="card">
                                    <h6 style="line-height: 21px">Mock Exam: {{ $m->mock_count }}</h6>
                                    <h6 style="line-height: 21px">Items: {{ $m->items }}</h6>
                                    <h6 style="line-height: 21px">Date Assigned: {{ $m->date_created }}</h6>
                                    <h6 style="line-height: 21px">Status: @switch($m->status)
                                            @case(1)
                                                Waiting to take
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
                                    @if ($m->date_started != null)
                                        <h6 style="line-height: 21px">Date Started: {{ $m->date_started }}</h6>
                                    @endif
                                    @if ($m->date_submitted != null)
                                        <h6 style="line-height: 21px">Date Submitted: {{ $m->date_submitted }}</h6>
                                        <h5 style="line-height: 21px;margin-top:10px">Score: {{ $m->score }}/
                                            {{ $m->items }}</h5>
                                        <h5 style="line-height: 21px;">Percentage:
                                            {{ ($m->score / $m->items) * 100 }}%</h5>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
<div class="modal fade" id="makeSession" tabindex="-1" aria-labelledby="makeSessionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                {{-- <button type="button" style="float: right" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                <form method="post" style="padding: 0 10px 10px 10px"
                    action="{{ route('create.session', [
                        'id' => $availed->id,
                    ]) }}">
                    @csrf
                    {{-- <h5 style="margin-bottom: 10px">Create a session</h5> --}}
                    <div class="mb-3" style="margin-bottom: 0">
                        <label for="exampleInputEmail1" class="form-label">Number of session:</label>
                        <input type="number" name="count" class="form-control">
                    </div>
                    <div style="padding: 0 0 0px  0">
                        <div class="row justify-content-end">
                            <div class="col-12">
                                <input type="submit" class="btn-form" value="Create"
                                    style="font-size: 15px !important">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="remarksModal" tabindex="-1" aria-labelledby="makeSessionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                {{-- <button type="button" style="float: right" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                <form method="post" style="padding: 0 10px 10px 10px"
                    action="/availed/courses/{{ $availed->id }}/view/setcompleted">
                    @csrf
                    {{-- <h5 style="margin-bottom: 20px">Set course as completed</h5> --}}
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Select Remarks:</label>
                        <Select class="form-control" name="remarks" id="remarks" required>
                            <option value="">Select Remarks</Option>
                            <option value="Passed">Passed</Option>
                            <option value="Failed">Failed</Option>
                        </Select>
                    </div>
                    <div style="padding: 0 0 0px  0">
                        <div class="row justify-content-end">
                            <div class="col-12">
                                <input type="submit" class="btn-form" value="Set as completed"
                                    style="font-size: 15px !important">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-lg" id="scheduleView" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" id="exampleModalLabel">Schedule Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="" style="padding: 20px 7px" id="body">

            </div>
        </div>
    </div>
</div>
@if (session('message'))
    <script>
        Toastify({
            text: "{{ session('message') }}",
            duration: 2000,
            gravity: "top", // `top` or `bottom`
            position: "center", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: "forestgreen",
            },
            onClick: function() {} // Callback after click
        }).showToast();
    </script>
@endif
@if (session('message-error'))
    <script>
        Toastify({
            text: "{{ session('message-error') }}",
            duration: 2000,
            gravity: "top", // `top` or `bottom`
            position: "center", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: "red",
            },
            onClick: function() {} // Callback after click
        }).showToast();
    </script>
@endif

<script>
    function showSched(id) {
        $('#scheduleView').modal('show');
        $('#body').html(`<center><h5>Loading...</h5></center>`);
        $.ajax({
            method: 'POST',
            url: "{{ route('view.sched') }}",
            data: {
                'id': id
            },
            success: function(response) {
                console.log(response);
                $('#body').html(response);
            }
        });
    }
</script>
@include(SchoolFileHelper::$footer)
