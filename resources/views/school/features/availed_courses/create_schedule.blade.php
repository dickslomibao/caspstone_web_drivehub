@include(SchoolFileHelper::$header, ['title' => 'Orders and payment'])
<style>
    .button-bottom {
        display: flex;
        justify-content: space-between;
    }

    #btn-practical-find,
    #btn-submit {
        background-color: var(--secondaryBG);
        border: none;
        color: #fff;
        font-size: 15px;
        border-radius: 5px;
        padding: 8px 40px;
    }

    .card-prompt {
        border-radius: 5px;
        background-color: var(--backgroundHeader);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 80px;
        padding: 15px;
    }
</style>
{{-- @dd($d_time) --}}
<div class="container-fluid" style="padding: 20px;margin-top: 60px">
    <form method="POST" id="form-create">
        @csrf
        <div class="row">
            <div class="col-12" style="margin-bottom: 15px">
                <h6 style="margin-bottom: 5px">Course Name: {{ $course->name }}</h6>
                <h6 style="margin-bottom: 5px">Duration: {{ $course->duration }} hrs</h6>
                <h6 style="margin-bottom: 5px">Student name: {{ $course->firstname }} {{ $course->lastname }}</h6>
            </div>
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6>Session {{ $session->session_number }}</h6>
                <div>
                    <h6>Total Assigned Hours: {{ $total_assign_hours }} hrs</h6>
                    <h6 style="margin-bottom: 5px">Remaining
                        hours:{{ $course->duration - $total_assign_hours }}
                        hrs</h6>
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3" style="margin-bottom: 0">
                    <label for="exampleInputEmail1" class="form-label">Start Date and time:</label>
                    <input min="{{ now()->format('Y-m-d\TH:i') }}" type="datetime-local" value=""
                        name="start_date" value="" class="form-control" id="start_date">
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3" style="margin-bottom: 0">
                    <label for="exampleInputEmail1" class="form-label">End Date and time</label>
                    <input min="{{ now()->format('Y-m-d\TH:i') }}" type="datetime-local" value="" name="end_date"
                        class="form-control" id="end_date">
                </div>
            </div>
            <div class="button-bottom" id="find-container" style="margin:15px 0 30px 0">
                <div></div>
                <button type="button" id="btn-practical-find">Find Instructor and Vehicles</button>
            </div>
            <div class="col-12">
                <div class="card-prompt" id="prompter">
                    <h6>Available Instructor and Vehicle will display here.</h6>
                </div>
            </div>
            <div style="display: none" id="select-container">
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3" style="margin-bottom: 0">
                            <label for="exampleInputEmail1" class="form-label">Select
                                Instructors:</label>
                            <select class="form-control" name="instructor" id="instructor" required>
                                <option value="">Select instructor</Option>
                                @foreach ($instructors as $instructor)
                                    <option value="{{ $instructor->user_id }}" id="{{ $instructor->user_id }}">
                                        {{ $instructor->firstname }}
                                        {{ $instructor->middlename }} {{ $instructor->lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3" style="margin-bottom: 0">
                            <label for="exampleInputEmail1" class="form-label">Select Vehicles:</label>
                            <Select class="form-control" name="vehicle" id="vehicle" required>
                                <option value="">Select vehicle</Option>
                                @foreach ($vehicles as $vehicle)
                                    <option id="{{ $vehicle->id }}" value="{{ $vehicle->id }}">
                                        {{ $vehicle->name }} ({{ $vehicle->year }}) ({{ $vehicle->model }})
                                        ({{ $vehicle->transmission }})
                                    </option>
                                @endforeach
                            </Select>
                        </div>
                    </div>
                    <div class="button-bottom">
                        <div></div>
                        {{-- <div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="" checked>
                                <label class="form-check-label" for="">
                                    Check Instructor Conflict
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="" checked>
                                <label class="form-check-label" for="">
                                    Check Vehicle Conflict
                                </label>
                            </div>
                        </div> --}}
                        <button type="submit" id="btn-submit">Set Schedule</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    let student_id = '{{ $course->student_id }}';
    let course_duration = parseFloat(`{{ $course->duration }}`);
    let total_assign = parseFloat(`{{ $total_assign_hours }}`);
    let studentConflict = false;
    $('#start_date').on('change', function() {
        $('#find-container').css('display', 'flex');
        $('#select-container').css('display', 'none');
        $('#prompter').css('display', 'flex');
    });
    $('#end_date').on('change', function() {
        $('#find-container').css('display', 'flex');
        $('#select-container').css('display', 'none');
        $('#prompter').css('display', 'flex');
    });

    function opentime(start_date) {
        var selectedDate = new Date(start_date);
        var dynamicOpeningTime = '{{ $d_time->opening_time }}';
        var openingTime = new Date();
        var openingTimeParts = dynamicOpeningTime.split(':');
        openingTime.setHours(parseInt(openingTimeParts[0]), parseInt(openingTimeParts[1]), parseInt(
            openingTimeParts[2] || 0), 0);

        if (selectedDate < openingTime) {
            return true;
        }
    }

    function sunday(start_date) {
        var currentDate = new Date(start_date);
        if (currentDate.getDay() === 0) {
            return true;
        }
    }

    function closetime(end_date) {
        var selectedDate = new Date(end_date);
        var dynamicOpeningTime = '{{ $d_time->closing_time }}';
        var openingTime = new Date();
        var openingTimeParts = dynamicOpeningTime.split(':');
        openingTime.setHours(parseInt(openingTimeParts[0]), parseInt(openingTimeParts[1]), parseInt(
            openingTimeParts[2] || 0), 0);

        if (selectedDate > openingTime) {
            return true;
        }
    }
    $('#btn-practical-find').on('click', function() {
        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();
        if (end_date <= start_date) {
            alert('Selected start and end date is invalid.');
            return;
        }

        if (!areDatesOnSameDay(start_date, end_date)) {
            alert('Cannot create schedule that have different day.');
            return;
        }

        if ('{{ $d_time->type }}' == '1') {
            if (sunday(start_date)) {
                alert('Cannot create schedule on sunday');
                return;
            }
        }

        if (opentime(start_date)) {
            alert('Cannot create schedule. Your opening time is ' + '{{ $d_time->opening_time }}');
            return;
        }
        if (closetime(end_date)) {
            alert('Cannot create schedule. Your closing time is ' + '{{ $d_time->closing_time }}');
            return;
        }

        let temp_calc = calculateHoursDifference(start_date, end_date);

        if ((total_assign + temp_calc) > course_duration) {
            alert(`The course have only remaining ${course_duration - total_assign} hrs`);
            return;
        };
        $.ajax({
            type: "POST",
            url: "{{ route('schedule.conflict') }}",
            data: {
                'id': 0,
                'start_date': start_date,
                'end_date': end_date,
            },
            success: function(response) {
                studentConflict = false;
                $('#find-container').css('display', 'none');
                $('#select-container').css('display', 'block');
                $('#prompter').css('display', 'none');
                $('option').prop('disabled', false);
                $('select').val("");
                let result = response;
                console.log(response);

                result['instructors'].forEach(element => {
                    $('#' + element['instructor_id']).prop('disabled', true);
                });

                result['vehicles'].forEach(element => {
                    $('#' + element['vehicle_id']).prop('disabled', true);
                });

                result['students'].forEach(element => {

                    studentConflict = true;
                    if (element['student_id'] == student_id) {
                        alert('The student are not available in that time.');
                        $('#find-container').css('display', 'flex');
                        $('#select-container').css('display', 'none');
                        $('#prompter').css('display', 'flex');

                    }
                });
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    function isStartDateLessThanNow(startDateString) {
        // Parse the event start date using Moment.js
        var eventStartDate = moment(startDateString);

        // Get the current date and time
        var now = moment();

        // Compare the event start date with the current date and time
        return eventStartDate.isBefore(now);
    }
    $('#form-create').submit(function(e) {
        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();
        console.log(calculateHoursDifference(start_date, end_date));
    });

    function calculateHoursDifference(startDate, endDate) {
        const start = new Date(startDate);
        const end = new Date(endDate);

        const exclusionStartTime = new Date(start);
        exclusionStartTime.setHours(12, 0, 0, 0);
        const exclusionEndTime = new Date(start);
        exclusionEndTime.setHours(13, 0, 0, 0);

        let timeDifference = Math.abs(end - start);

        if (start < exclusionEndTime && end > exclusionStartTime) {

            const overlapStartTime = Math.max(start, exclusionStartTime);
            const overlapEndTime = Math.min(end, exclusionEndTime);
            const overlapDuration = Math.abs(overlapEndTime - overlapStartTime);
            timeDifference -= overlapDuration;

        }
        const hoursDifference = timeDifference / (1000 * 60 * 60);
        return hoursDifference;
    }

    function areDatesOnSameDay(startDate, endDate) {
        const start = new Date(startDate);
        const end = new Date(endDate);

        const startDay = start.getDate();
        const startMonth = start.getMonth();
        const startYear = start.getFullYear();

        const endDay = end.getDate();
        const endMonth = end.getMonth();
        const endYear = end.getFullYear();

        return startDay === endDay && startMonth === endMonth && startYear === endYear;
    }
</script>





{{-- <script>
    let valid = false;
    $('#form-create').submit(function(e) {

        let remaining_hours = Number.parseFloat("{{ $remaining_hours }}");
        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();
        let total_selected_hours = calculateHoursDifference(start_date, end_date).toFixed(2);

        if (end_date <= start_date) {
            alert('Selected start and end date is invalid.');
            e.preventDefault();
            return;
        }
        if (total_selected_hours > remaining_hours) {
            alert(`You have only ${remaining_hours} hrs. Check your selected start date and end date.`);
            e.preventDefault();
            return;
        }
        if (valid == false) {
            e.preventDefault();
            $('#btn-submit').html('Checking conflict...');
            setTimeout(() => {
                $.ajax({
                    type: "POST",
                    url: "{{ route('instrutor.checkconflict') }}",
                    data: {
                        'id': $('#instructor').val(),
                        'start_date': start_date,
                        'end_date': end_date,
                        'session_id': "{{ $session->id }}",
                    },
                    success: function(response) {
                        console.log(response);
                        if (response == 0) {
                            valid = true;
                            $('#form-create').submit();
                        } else {
                            alert('instructor conflict');
                        }

                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
                $('#btn-submit').html('Set Schedule');
            }, 2000);
        }
    });
    $('#instructor').change(function(e) {
        $.ajax({
            type: "POST",
            url: "{{ route('instrutor.schedule') }}",
            data: {
                'id': $('#instructor').val(),
            },
            success: function(response) {
                if (response.length == 0) {
                    $('#instructor-display').html(`<p>No Scheduled yet`);
                }
            },
            error: function(err) {
                console.log(err);
            }
        });
    });

    function calculateHoursDifference(startDate, endDate) {
        const start = new Date(`${startDate}`);
        const end = new Date(`${endDate}`);

        const timeDifference = Math.abs(end - start);
        const hoursDifference = timeDifference / (1000 * 60 * 60);

        return hoursDifference;
    }
</script> --}}
@include(SchoolFileHelper::$footer)
