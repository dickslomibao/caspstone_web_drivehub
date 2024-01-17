@include(SchoolFileHelper::$header, ['title' => 'Update Theroritical Schedules'])

<style>
    .button-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center
    }

    button {
        background-color: var(--secondaryBG);
        border: none;
        color: #fff;
        width: 200px;
        padding: 0 20px;
        height: 40px;
        font-size: 15px;
        border-radius: 5px;
    }
</style>

<div class="container-fluid" style="padding: 25px;margin-top:60px;">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">

                <form method="post" id="form-create"
                    action="
                {{ route('updateAction.theoritical', [
                    'id' => $theoritical->id,
                ]) }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3" style="margin-bottom: 0">
                                <label for="exampleInputEmail1" class="form-label">Title:</label>
                                <input type="text" value="{{ $theoritical->title }}" name="title" value=""
                                    class="form-control" id="title" required>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3" style="margin-bottom: 0">
                                <label for="exampleInputEmail1" class="form-label">Slots:</label>
                                <input type="number" min="9" value="{{ $theoritical->slot }}" name="slot"
                                    class="form-control" id="slots" required>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3" style="margin-bottom: 0">
                                <label for="exampleInputEmail1" class="form-label">For session number:</label>
                                <input {{ count($students) == 0 ? '' : 'readonly' }} type="number"
                                    value="{{ $theoritical->for_session_number }}" name="session_number"
                                    class="form-control" id="session_numbers" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3" style="margin-bottom: 0">
                                <label for="exampleInputEmail1" class="form-label">Start date:</label>
                                <input type="datetime-local" value="{{ $theoritical->start_date }}" name="start_date"
                                    class="form-control" id="start_date" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3" style="margin-bottom: 0">
                                <label for="exampleInputEmail1" class="form-label">End date:</label>
                                <input type="datetime-local" value="{{ $theoritical->end_date }}" name="end_date"
                                    class="form-control" id="end_date" required>
                            </div>
                        </div>
                    </div>
                    <div id="find-container">
                        <div class="row">
                            <div class="col-12 d-flex align-items-center justify-content-end">
                                <button type="button" id="btn-theoritical-find">Update Schedule</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card" style="margin-top: 20px">
                <div class="d-flex justify-content-between align-items-center">
                    <h6>Instructor:</h6>
                </div>
                <div class="row">
                    @foreach ($instructors as $instructor)
                        <div class="col-lg-4  mt-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center" style="gap: 10px;">
                                    <img src="/{{ $instructor->profile_image }}" class="rounded-circle"
                                        style="width: 40px;height:40px; object-fit: cover;" alt="Avatar" />
                                    <div>
                                        <h6
                                            style="max-width:150px;
                        white-space: nowrap;
                        overflow: hidden;
                        text-overflow: ellipsis;">
                                            {{ $instructor->firstname }} {{ $instructor->lastname }}</h6>
                                        <p class="email">{{ $instructor->email }}</p>

                                    </div>
                                </div>
                                @if ($theoritical->status == 1)
                                    @if (count($instructors) > 1)
                                        <a class="x-a"
                                            onclick="r= confirm('Are you sure you want to remove the instructor ?');if(r==true){location.href='/school/theoritical/{{ $theoritical->id }}/view/{{ $theoritical->schedule_id }}/schedule/{{ $instructor->user_id }}/removeinstructor';}">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    @endif
                                @endif
                            </div>
                            <p class="error-i" id="error-{{ $instructor->user_id }}"
                                style="color: red;margin-top:10px;font-size:15px;display:none";>Not available on that
                                day</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <h6>Student List: {{ count($students) }}</h6>
            @foreach ($students as $student)
                <div class="col-12  mt-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center" style="gap: 10px;">
                            <img src="/{{ $student->profile_image }}" class="rounded-circle"
                                style="width: 40px;height:40px; object-fit: cover;" alt="Avatar" />
                            <div>
                                <h6
                                    style="max-width:150px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;">
                                    {{ $student->firstname }} {{ $student->lastname }}</h6>
                                <p class="email">{{ $student->email }}</p>
                            </div>
                        </div>
                        @if ($theoritical->status == 1 || $theoritical->status == 2)
                            <a href="" class="x-a">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>
    </div>
</div>
<script>
    $('#btn-theoritical-find').on('click', function() {
        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();
        let student_count = {{ count($students) }};
        if ($('#title').val() == "") {
            alert('Title is required');
            return;
        }
        if ($('#title').val() == "") {
            alert('Title is required');
            return;
        }
        if (start_date == "") {
            alert('Start date is required');
            return;
        }
        if (end_date == "") {
            alert('End date is required');
            return;
        }
        if (end_date <= start_date) {
            alert('Selected start and end date is invalid.');
            return;
        }
        if (!areDatesOnSameDay(start_date, end_date)) {
            alert('Cannot create schedule that have different day.');
            return;
        }
        if (parseInt($('#slots').val()) <=0) {
            alert('Slot cannot be 0 or negative');
            return;
        }
        if (parseInt($('#slots').val()) < student_count && student_count != 0) {
            alert('Slot should be greaterthan the student count');
            return;
        }
        let c = 0;
        $('.error-i').css('display', 'none');
        $.ajax({
            type: "POST",
            url: "{{ route('schedule.conflict') }}",

            data: {
                'id': '{{ $theoritical->schedule_id }}',
                'start_date': start_date,
                'end_date': end_date,
            },
            success: function(response) {
                let result = response;
                console.log(response);
                result['instructors'].forEach(element => {
                    if ($('#error-' + element['instructor_id']).length) {
                        c++;
                        $('#error-' + element['instructor_id']).css('display', 'block');
                    }
                });
                if (c == 0) {
                    $('#form-create').submit();
                }
            },
            error: function(error) {
                alert(error);
            },
            beforeSend: function(response) {
                $('#btn-theoritical-find').text("Checking");
                $('#btn-theoritical-find').prop('disabled', true);
            },
            complete: function(response) {
                $('#btn-theoritical-find').text("Update Schedule");
                $('#btn-theoritical-find').prop('disabled', false);
            }
        });
    });

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
@include(SchoolFileHelper::$footer)
