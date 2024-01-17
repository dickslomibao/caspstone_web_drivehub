@include(SchoolFileHelper::$header, ['title' => 'Instructor More Details'])

<style>
    .all {
        background: var(--primaryBG);
        color: white;
        padding: 6px 20px 6px 20px;
        border-radius: 10px;
        border: var(--primaryBG);
    }

    .completed-btn {
        background: grey;
        color: black;
        padding: 6px 20px 6px 20px;
        border-radius: 10px;
        border: grey;
    }


    .incoming {
        background: grey;
        color: black;
        padding: 6px 20px 6px 20px;
        border-radius: 10px;
        border: grey;
    }
</style>


<script>
    $(document).ready(function() {
        $('#table').DataTable();
        $('#table_1').DataTable();
    });
</script>

<div class="container-fluid" style="padding: 20px;margin-top:60px">

    <div class="row">
        <div class="col-12">
            <h6 style="margin-bottom: 15px">Personal Information</h6>
            <div class="card">
                <div class="d-flex align-items-center justify-content-between" style="margin: 10px 0;column-gap:10px">
                    <div class="d-flex align-items-center" style="column-gap:10px">
                        <img src="/{{ $details->profile_image }}" alt=""
                            style="width: 40px;height:40px;object-fit:cover;border-radius:50%">
                        <div>
                            <h6 style="font-weight: 500">
                                {{ $details->firstname }} {{ $details->lastname }}
                            </h6>
                            <p style="font-size: 14px;font-weight:500">
                                {{ $details->email }}
                            </p>
                        </div>
                    </div>
                </div>
                <h6 style="line-height: 22px">Sex: {{ $details->sex }}</h6>
                <h6 style="line-height: 22px">Birthdate: {{ $details->birthdate }}</h6>
                <h6 style="line-height: 22px">Phone Number: {{ $details->phone_number }}</h6>
                <h6 style="line-height: 22px">Address: {{ $details->address }}</h6>
            </div>

        </div>
        {{-- <div class="col-lg-12">
            <div class="col-12" style="margin:10px 0 30px 0">
                <h6>Personal Information</h6>
            </div>
            <div style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;padding:20px;border-radius:20px">
                <div class="row">

                    <div class="col-lg-4">

                        <div class="mb-3">
                            <label for="firstname" class="form-label">Firstname: <i id="check-firstname"
                                    class="fa-solid fa-check check-label" style=""></i></label>
                            <div>
                                <input type="hidden" class="form-control" name="user_id"
                                    value="{{ $details->user_id }}" />
                                <input type="text" class="form-control" name="firstname"
                                    value="{{ $details->firstname }}" id="firstname" id="firstname"
                                    placeholder="Enter firstname..." required disabled />
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="middlename" class="form-label">Middlename:(optional) <i id="check-middlename"
                                    class="fa-solid fa-check check-label" style=""></i></label>
                            <input type="text" class="form-control" id="middlename"
                                value="{{ $details->middlename }}" name="middlename" placeholder="Enter middlename..."
                                required disabled />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="lastname" class="form-label">Lastname: <i id="check-lastname"
                                    class="fa-solid fa-check check-label" style=""></i></label>
                            <input type="text" class="form-control" id="lastname" value="{{ $details->lastname }}"
                                name="lastname" required placeholder="Enter lastname..." disabled />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="birthdate" class="form-label">Birthdate: <i id="check-birthdate"
                                    class="fa-solid fa-check check-label" style=""></i></label>
                            <input type="date" class="form-control" id="birthdate" name="birthdate" required
                                placeholder="" value="{{ $details->birthdate }}" disabled />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="sex" class="form-label">Sex: <i id="check-sex"
                                    class="fa-solid fa-check check-label" style=""></i></label>
                            <select class="form-select" name="sex" id="sex"
                                aria-label="Default select example" required disabled>
                                <option selected value="">Select sex</option>
                                <option value="Male" {{ $details->sex == 'Male' ? 'selected' : '' }}>Male
                                </option>
                                <option value="Female" {{ $details->sex == 'Female' ? 'selected' : '' }}>Female
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone number <i id="check-phone_number"
                                    class="fa-solid fa-check check-label" style=""></i></label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" required
                                placeholder="+639123456789" value="{{ $details->phone_number }}" disabled />
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="address" class="form-label">Address <i id="check-address"
                                    class="fa-solid fa-check check-label" style=""></i></label>
                            <input class="form-control" required id="address" name="address"
                                value="{{ $details->address }}" placeholder="Enter address..." disabled />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">

                            <label class="form-label">Valid ID Image:</label>
                            <div class="col-10 mx-auto">
                                <img class="img-fluid" style="border-radius: 10px" src="/{{ $details->valid_id }}"
                                    alt="" srcset="">
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Drivers License Image:</label>
                            <div class="col-10 mx-auto">
                                <img class="img-fluid" style="border-radius: 10px" src="/{{ $details->license }}"
                                    alt="" srcset="">
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div style="margin-top:20px;padding:20px 0;">
                <div class="row justify-content-end">
                    <div class="col-lg-3">
                        <!-- <input type="submit" class="btn-form" value="Update Instructor"> -->
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    <div class="row" style="margin-top: 20px">

        <div class="col-lg-12">
            <div class="col-12" style="margin-bottom:20px">
                <h6>Instructor Schedule</h6>
            </div>

            <div class="card">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                            aria-selected="true">Theoretical Schedule</button>
                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                            type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Practical
                            Schedule</button>

                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                        tabindex="0">
                        <!-- Start Theoretical Schedule Tab -->
                        <div class="col-12 mt-3">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-home" type="button" role="tab"
                                        aria-controls="pills-home" aria-selected="true">All</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-profile" type="button" role="tab"
                                        aria-controls="pills-profile" aria-selected="false">Incoming</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-contact" type="button" role="tab"
                                        aria-controls="pills-contact" aria-selected="false">Completed</button>
                                </li>

                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                    aria-labelledby="pills-home-tab" tabindex="0">
                                    <!-- All Tab -->
                                    @if ($Theodatarowcount == 'None')

                                        <div class="card" style="margin: 10px 0 20px 0">

                                            <center>No Schedule Available</center>
                                        </div>
                                    @else
                                        <div class="card" style="margin: 10px 0 20px 0">
                                            @php
                                                $currentDate = null;
                                            @endphp

                                            @foreach ($schedule as $sched)
                                                @php
                                                    $startDate = \Carbon\Carbon::parse($sched->start_date)->format('D - F j,
                                            Y');
                                                @endphp

                                                @if ($currentDate !== $startDate)
                                                    @if ($currentDate !== null)
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

                                        <b>{{ $formattedTime }} - {{ $formattedTime1 }} </b>
                                        <div class="card mb-3">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <b>Session</b> {{ $sched->for_session_number }}<br>
                                                    <b>Title:</b> {{ $sched->title }} <br>
                                                    <b>Students: </b> <span style="color:blue;"><a
                                                            class="dropdown-item view-students" href="#"
                                                            data-id="{{ $sched->id }}">View
                                                            Students</a></span>
                                                </div>
                                                <div class="col-sm-4 text-end">
                                                    <i class="fa-solid fa-stopwatch"></i> &nbsp;
                                                    {{ $totalHours }} hrs
                                                </div>
                                            </div>
                                        </div>

                                        @php
                                            $currentDate = $startDate;
                                        @endphp
                                        @endforeach

                                        @if ($currentDate !== null)
                                    </div> <!-- Close the last date div -->
                                    @endif
                                </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                aria-labelledby="pills-profile-tab" tabindex="0">
                                <!-- Incoming -->
                                @if ($Theoincomingcount == 'None')

                                    <div class="card" style="margin: 10px 0 20px 0">

                                        <center>No Schedule Available</center>
                                    </div>
                                @else
                                    <div class="card" style="margin: 10px 0 20px 0">
                                        @php
                                            $currentDate = null;
                                        @endphp

                                        @foreach ($TheoschedIcoming as $sched)
                                            @php
                                                $startDate = \Carbon\Carbon::parse($sched->start_date)->format('D - F j, Y');
                                            @endphp

                                            @if ($currentDate !== $startDate)
                                                @if ($currentDate !== null)
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

                                    <b>{{ $formattedTime }} - {{ $formattedTime1 }} </b>
                                    <div class="card mb-3">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <b>Session</b> {{ $sched->for_session_number }}<br>
                                                <b>Title:</b> {{ $sched->title }} <br>
                                                <b>Students: </b> <span style="color:blue;"><a
                                                        class="dropdown-item view-students" href="#"
                                                        data-id="{{ $sched->id }}">View
                                                        Students</a></span>
                                            </div>
                                            <div class="col-sm-4 text-end">
                                                <i class="fa-solid fa-stopwatch"></i> &nbsp; {{ $totalHours }}
                                                hrs
                                            </div>
                                        </div>
                                    </div>

                                    @php
                                        $currentDate = $startDate;
                                    @endphp
                                    @endforeach

                                    @if ($currentDate !== null)
                                </div> <!-- Close the last date div -->
                                @endif
                            </div>

                            @endif




                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                            aria-labelledby="pills-contact-tab" tabindex="0">
                            <!-- Completed Tab -->
                            @if ($Theocompcount == 'None')

                                <div class="card" style="margin: 10px 0 20px 0">

                                    <center>No Schedule Available</center>
                                </div>
                            @else
                                <div class="card" style="margin: 10px 0 20px 0">
                                    @php
                                        $currentDate = null;
                                    @endphp

                                    @foreach ($TheoschedComp as $sched)
                                        @php
                                            $startDate = \Carbon\Carbon::parse($sched->start_date)->format('D - F j, Y');
                                        @endphp

                                        @if ($currentDate !== $startDate)
                                            @if ($currentDate !== null)
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

                                <b>{{ $formattedTime }} - {{ $formattedTime1 }} </b>
                                <div class="card mb-3">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <b>Session</b> {{ $sched->for_session_number }}<br>
                                            <b>Title:</b> {{ $sched->title }} <br>
                                            <b>Students: </b> <span style="color:blue;"><a
                                                    class="dropdown-item view-students" href="#"
                                                    data-id="{{ $sched->id }}">View
                                                    Students</a></span>
                                        </div>
                                        <div class="col-sm-4 text-end">
                                            <i class="fa-solid fa-stopwatch"></i> &nbsp; {{ $totalHours }} hrs
                                        </div>
                                    </div>
                                </div>

                                @php
                                    $currentDate = $startDate;
                                @endphp
                                @endforeach

                                @if ($currentDate !== null)
                            </div> <!-- Close the last date div -->
                            @endif
                        </div>

                        @endif

                    </div>

                </div>


            </div>

            <!-- End Theoretical Schedule Tab -->

        </div>
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"
            tabindex="0">
            <!-- Start Practical Schedule Tab -->


            <div class="col-12 mt-3">



                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-all-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-all"
                            aria-selected="true">All</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-incoming-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-incoming" type="button" role="tab"
                            aria-controls="pills-incoming" aria-selected="false">Incoming</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-completed-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-completed" type="button" role="tab"
                            aria-controls="pills-completed" aria-selected="false">Completed</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-all" role="tabpanel"
                        aria-labelledby="pills-all-tab" tabindex="0">

                        <!-- All Tab -->

                        @if ($pracCount == 'None')

                            <div class="card" style="margin: 10px 0 20px 0">

                                <center>No Schedule Available</center>
                            </div>
                        @else
                            <div class="card" style="margin: 10px 0 20px 0">
                                @php
                                    $currentDate = null;
                                @endphp

                                @foreach ($practical as $sched)
                                    @php
                                        $startDate = \Carbon\Carbon::parse($sched->start_date)->format('D - F j, Y');
                                    @endphp

                                    @if ($currentDate !== $startDate)
                                        @if ($currentDate !== null)
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

                            <b>{{ $formattedTime }} - {{ $formattedTime1 }} </b>
                            <div class="card mb-3">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <b>Course: </b> {{ $sched->name }}<br>
                                        <b>Vehicle:</b> {{ $sched->vehicle_name }} <br>
                                        <b>Plate Number: </b> {{ $sched->plate_number }}<br>
                                        <b>Student: </b> {{ $sched->firstname }} {{ $sched->middlename }}
                                        {{ $sched->lastname }}
                                    </div>
                                    <div class="col-sm-4 text-end">
                                        <i class="fa-solid fa-stopwatch"></i> &nbsp; {{ $totalHours }} hrs
                                    </div>
                                </div>
                            </div>

                            @php
                                $currentDate = $startDate;
                            @endphp
                            @endforeach

                            @if ($currentDate !== null)
                        </div> <!-- Close the last date div -->
                        @endif
                    </div>
                    @endif
                </div>
                <div class="tab-pane fade" id="pills-incoming" role="tabpanel" aria-labelledby="pills-incoming-tab"
                    tabindex="0">
                    <!-- Incoming Tab -->
                    @if ($pracIncomingCount == 'None')

                        <div class="card" style="margin: 10px 0 20px 0">

                            <center>No Schedule Available</center>
                        </div>
                    @else
                        <div class="card" style="margin: 10px 0 20px 0">
                            @php
                                $currentDate = null;
                            @endphp

                            @foreach ($practIncoming as $sched)
                                @php
                                    $startDate = \Carbon\Carbon::parse($sched->start_date)->format('D - F j, Y');
                                @endphp

                                @if ($currentDate !== $startDate)
                                    @if ($currentDate !== null)
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

                        <b>{{ $formattedTime }} - {{ $formattedTime1 }} </b>
                        <div class="card mb-3">
                            <div class="row">
                                <div class="col-sm-8">
                                    <b>Course: </b> {{ $sched->name }}<br>
                                    <b>Vehicle:</b> {{ $sched->vehicle_name }} <br>
                                    <b>Plate Number: </b> {{ $sched->plate_number }}<br>
                                    <b>Student: </b> {{ $sched->firstname }} {{ $sched->middlename }}
                                    {{ $sched->lastname }}
                                </div>
                                <div class="col-sm-4 text-end">
                                    <i class="fa-solid fa-stopwatch"></i> &nbsp; {{ $totalHours }} hrs
                                </div>
                            </div>
                        </div>

                        @php
                            $currentDate = $startDate;
                        @endphp
                        @endforeach

                        @if ($currentDate !== null)
                    </div> <!-- Close the last date div -->
                    @endif
                </div>

                @endif


            </div>
            <div class="tab-pane fade" id="pills-completed" role="tabpanel" aria-labelledby="pills-completed-tab"
                tabindex="0">


                <!-- Completed Tab -->

                @if ($pracCompCount == 'None')

                    <div class="card" style="margin: 10px 0 20px 0">

                        <center>No Schedule Available</center>
                    </div>
                @else
                    <div class="card" style="margin: 10px 0 20px 0">
                        @php
                            $currentDate = null;
                        @endphp

                        @foreach ($practCompleted as $sched)
                            @php
                                $startDate = \Carbon\Carbon::parse($sched->start_date)->format('D - F j, Y');
                            @endphp

                            @if ($currentDate !== $startDate)
                                @if ($currentDate !== null)
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

                    <b>{{ $formattedTime }} - {{ $formattedTime1 }} </b>
                    <div class="card mb-3">
                        <div class="row">
                            <div class="col-sm-8">
                                <b>Course: </b> {{ $sched->name }}<br>
                                <b>Vehicle:</b> {{ $sched->vehicle_name }} <br>

                                <b>Plate Number: </b> {{ $sched->plate_number }}<br>
                                <b>Student: </b> {{ $sched->firstname }} {{ $sched->middlename }}
                                {{ $sched->lastname }}
                            </div>
                            <div class="col-sm-4 text-end">
                                <i class="fa-solid fa-stopwatch"></i> &nbsp; {{ $totalHours }} hrs
                            </div>
                        </div>
                    </div>
                    @php
                        $currentDate = $startDate;
                    @endphp
                    @endforeach

                    @if ($currentDate !== null)
                </div> <!-- Close the last date div -->
                @endif
            </div>

            @endif
        </div>
    </div>
</div>
<!-- End Practical Schedule Tab -->
</div>








<!-- modal -->

<div class="modal fade" id="view_scheduled_students" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" id="modal_title_view">Lists of Students: </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <br>
                <table id="students_table" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    let studentsTable;

    function displayStudents(id) {
        $.ajax({
            type: "POST",
            url: "/school/instructors/" + id + "/viewStudents",
            dataType: 'json', // Specify that the expected response is JSON
            success: function(response) {
                if (studentsTable) {
                    studentsTable.destroy();
                }
                studentsTable = $('#students_table').DataTable({
                    order: [1, 'desc'], // Specify the correct order based on the number of columns
                    data: response, // No need to parse the response again
                    columns: [{
                            data: function(data, type, row) {
                                return `
                                <div class="d-flex align-items-center" style="gap: 10px; padding: 5px 0;">
                                    <img src="/${data.profile_image}" class="rounded-circle" style="width: 40px; height: 40px;" alt="Avatar" />
                                    <div>
                                        <h6>${data.firstname} ${data.middlename} ${data.lastname}</h6>
                                        <p style="font-size: 14px;" class="email">${data.email}</p>
                                    </div>
                                </div>`;
                            }
                        },
                        {
                            data: 'email'
                        }
                    ],
                });
            }
        });
    }




    $(document).on('click', '.view-students', function() {
        $('#view_scheduled_students').modal('show');
        var id = $(this).data('id');
        displayStudents(id);
    });
</script>


@include(SchoolFileHelper::$footer)
