@include(SchoolFileHelper::$header, ['title' => 'Create Theroritical Schedules'])

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

<div class="container-fluid" style="padding: 25px;margin-top:60px">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form method="post" id="form-create">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3" style="margin-bottom: 0">
                                <label for="exampleInputEmail1" class="form-label">Title:</label>
                                <input type="text" value="" name="title" value="" class="form-control"
                                    id="title" required>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3" style="margin-bottom: 0">
                                <label for="exampleInputEmail1" class="form-label">Slots:</label>
                                <input type="number" value="" name="slot" value="" class="form-control"
                                    id="slots" required>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3" style="margin-bottom: 0">
                                <label for="exampleInputEmail1" class="form-label">For session number:</label>
                                <input type="number" value="" name="session_number" value=""
                                    class="form-control" id="session_numbers" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3" style="margin-bottom: 0">
                                <label for="exampleInputEmail1" class="form-label">Start date:</label>
                                <input min="{{ now()->format('Y-m-d\TH:i') }}" type="datetime-local" value=""
                                    name="start_date" value="" class="form-control" id="start_date" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3" style="margin-bottom: 0">
                                <label for="exampleInputEmail1" class="form-label">End date:</label>
                                <input min="{{ now()->format('Y-m-d\TH:i') }}" type="datetime-local" value=""
                                    name="end_date" value="" class="form-control" id="end_date" required>
                            </div>
                        </div>
                    </div>
                    <div id="find-container">
                        <div class="row">
                            <div class="col-12 d-flex align-items-center justify-content-end">
                                <button type="button" id="btn-theoritical-find">Find instructor</button>
                            </div>
                        </div>
                    </div>
                    <div style="margin: 20px 0" id="prompter">
                        <div class="row">
                            <div class="col-12">
                                <div class="card text-center" style="padding: 25px">
                                    <h6>Available Instuctor Will Display Here.</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="select-container" style="display:none">
                        <div class="row">
                            <label for="exampleInputEmail1" class="form-label">Select Instructors:</label>
                            @foreach ($instructors as $instructor)
                                <div class="col-lg-3  mt-4 ins" style=""
                                    id="container-{{ $instructor->user_id }}">
                                    <div class="d-flex align-items-center" style="gap: 10px;padding:5px 0">
                                        <input type="checkbox" name="instructors[]" id="{{ $instructor->user_id }}"
                                            value="{{ $instructor->user_id }}" class="form-check-input"
                                            style="margin-right: 10px" />
                                        <img src="/{{ $instructor->profile_image }}" class="rounded-circle"
                                            style="width: 40px;height:40px;object-fit:cover" alt="Avatar" />
                                        <div>
                                            <h6
                                                style="max-width:150px;
                                        white-space: nowrap;
                                        overflow: hidden;
                                        text-overflow: ellipsis;">
                                                {{ $instructor->firstname }} {{ $instructor->lastname }}</h6>
                                            <p style="font-size:14px;max-width:150px;
                                            white-space: nowrap;
                                            overflow: hidden;
                                            text-overflow: ellipsis"
                                                class="email">{{ $instructor->email }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-12 d-flex align-items-center justify-content-end">
                                <button type="button" id="btn-add-s">Add Schedule</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#btn-add-s').click(function(e) {
        e.preventDefault();
        if ($('input[name="instructors\\[\\]"]:checked').length == 0) {
            alert("There is no selected instructor");
            return;
        }
        $('#form-create').submit();
    });
    $('#start_date').on('change', function() {
        $('#find-container').css('display', 'block');
        $('#select-container').css('display', 'none');
        $('#prompter').css('display', 'block');
        $('input[type="checkbox"]').prop('checked', false);
        $('.ins').css('display', 'block');
    });
    $('#end_date').on('change', function() {
        $('#find-container').css('display', 'block');
        $('#select-container').css('display', 'none');
        $('#prompter').css('display', 'block');
        $('input[type="checkbox"]').prop('checked', false);
        $('.ins').css('display', 'block');
    });

    $('#btn-theoritical-find').on('click', function() {
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
        $.ajax({
            type: "POST",
            url: "{{ route('schedule.conflict') }}",
            data: {
                'id': 0,
                'start_date': start_date,
                'end_date': end_date,
            },
            success: function(response) {
                $('#find-container').css('display', 'none');
                $('#select-container').css('display', 'block');
                $('#prompter').css('display', 'none');
                $('input[type="checkbox"]').prop('disabled', false);
                $('select').val("");
                let result = response;
                console.log(response);
                result['instructors'].forEach(element => {
                    $('#' + element['instructor_id']).prop('disabled', true);
                    $('#container-' + element['instructor_id']).css('display', 'none');
                });
            },
            error: function(error) {
                console.log(error);
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
