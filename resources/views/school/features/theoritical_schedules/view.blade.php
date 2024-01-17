@include(SchoolFileHelper::$header, ['title' => 'Theroritical Schedules'])
<style>
    h5 {
        line-height: 25px;
        font-size: 18px
    }

    .card-theoritical-info {
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
        padding: 20px;
        border-radius: 20px;


    }

    .card-theoritical-info h6 {
        line-height: 25px;
    }

    .btn-add-t {
        background-color: var(--primaryBG);
        border: none;
        outline: none;
        width: 100%;
        height: 38px;
        color: white;
        font-weight: 500;
        font-size: 14px;
        border-radius: 10px
    }

    .btn-update {

        background-color: rgba(84, 94, 225, .1);
        /*
        border: 1px solid  var(--secondaryBG); */
        border: none;
        outline: none;
        width: 100%;
        height: 38px;
        color: var(--primaryBG);
        font-weight: 500;
        font-size: 14px;
        border-radius: 10px;
    }

    .email {
        color: var(--textGrey);
        font-size: 14px;
        font-weight: 500;

    }

    .x-a {
        color: red
    }
</style>


<div class="container-fluid" style="padding:20px;margin-top:61px">
    <div class="row">

        <div class="col-lg-8">

            <div class="card" style=";">


                <h6 style="" class="d-flex align-items-center justify-content-between">
                    Title: {{ $theoritical->title }}

                    @switch($theoritical->status)
                        @case(1)
                            <div>
                                <span class="waiting" style="width:80px;float: right;">
                                    Waiting
                                </span>
                            </div>
                        @break

                        @case(2)
                            <div>
                                <span class="started" style="width:80px;float: right;">
                                    Started
                                </span>
                            </div>
                        @break

                        @case(3)
                            <div>
                                <span class="completed" style="width:80px;float: right;">
                                    Completed
                                </span>
                            </div>
                        @break

                        @default
                    @endswitch
                </h6>
                <h6 style="margin-top:5px">
                    Total Slots: {{ $theoritical->slot }}
                </h6>
                <h6 style="margin-top:5px">
                    For Session: {{ $theoritical->for_session_number }}
                </h6>

                <h6 style="margin-top: 10px">Date:
                    {{ date_format(date_create($theoritical->start_date), 'D - F d, Y') }}
                </h6>
                <h6 style="margin: 5px  0 10px 0">Time:
                    {{ date_format(date_create($theoritical->start_date), 'h:i A') }}
                    -
                    {{ date_format(date_create($theoritical->end_date), 'h:i A') }}
                </h6>
                @foreach ($logs as $log)
                    @if ($log->type == 1)
                        <h6>Date Started:
                            {{ date_format(date_create($log->date_process), 'D - F d, Y - h:i A') }}
                        </h6>
                    @endif
                    @if ($log->type == 2)
                        <h6 style="margin-top: 5px">Date Ended:
                            {{ date_format(date_create($log->date_process), 'D - F d, Y - h:i A') }}
                        </h6>
                    @endif
                @endforeach
                @if ($theoritical->status == 3)
                    <h6 style="margin-top: 5px">Completed Hours:
                        {{ $theoritical->complete_hours }} hrs
                    </h6>
                @endif
            </div>
            @if ($theoritical->status == 1)
                <div class="row" style="margin: 20px 0;">
                    <div class="col-lg-6">
                        <button class="btn-add-t" data-bs-toggle="modal" data-bs-target="#findStudent">Add
                            Student</button>
                    </div>
                    <div class="col-lg-6">
                        <button class="btn-update"
                            onclick="location.href='/school/theoritical/{{ $theoritical->id }}/update'">Update
                            Schedule</button>
                    </div>
                </div>
            @endif

            <div class="card" style="margin-top: 20px">
                <div class="d-flex justify-content-between align-items-center">
                    <h6>Instructor:</h6>
                    @if ($theoritical->status == 1)
                        <i class="far fa-plus" data-bs-toggle="modal" data-bs-target="#addInstructor"></i>
                    @endif
                </div>
                <div class="row">
                    @foreach ($instructors as $instructor)
                        <div class="col-lg-6  mt-4">
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
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
 
        <div class="col-lg-4">
            <h6>Student List</h6>
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
                        @if ($theoritical->status == 1)
                            <a class="x-a"
                                onclick="r= confirm('Are you sure you want to remove the student ?');if(r==true){location.href='/school/theoritical/{{ $theoritical->id }}/view/{{ $student->order_list_id }}/schedule/{{ $student->student_id }}/remove_student';}">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>
<div class="modal fade" id="findStudent" tabindex="-1" aria-labelledby="findStudentLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form
                action="{{ route('theoritical.addstudents', [
                    'id' => $theoritical->schedule_id,
                ]) }}"
                method="post" id="form-student">
                @csrf
                <div class="modal-header">
                    <h6 class="modal-title" id="findStudentLabel">List of pending students</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="find_student_container">
                    {{-- <div class="mb-4">
                        <label for="" class="form-label">Search by name:</label>
                        <input type="text" class="form-control" id="">
                    </div> --}}
                </div>
                <div class="modal-footer">
                    {{-- <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Check all
                        </label>
                    </div> --}}
                    <button class="btn-add" data-bs-toggle="modal" data-bs-target="#findStudent">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="addInstructor" tabindex="-1" aria-labelledby="findStudentLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form
                action="{{ route('theoritical.addinstructor', [
                    'theoritical_id' => $theoritical->id,
                ]) }}"
                method="post">
                @csrf
                <div class="modal-header">
                    <h6 class="modal-title" id="findStudentLabel">List of Available instructors</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="instructor_container">
                    {{-- <div class="mb-4">
                        <label for="" class="form-label">Search by name:</label>
                        <input type="text" class="form-control" id="">
                    </div> --}}

                    @foreach ($list_instructors as $i)
                        @if (!in_array($i->user_id, $not_available))
                            <div class="d-flex align-items-center justify-content-between"
                                style="gap: 10px;padding:5px 0;margin-bottom:10px">
                                <div class="d-flex align-items-center" style="gap: 10px;">
                                    <input type="checkbox" name="instructors[]" value="{{ $i->user_id }} "
                                        class="form-check-input" style="margin-right: 10px">
                                    <img src="/{{ $i->profile_image }}" class="rounded-circle"
                                        style="width: 40px;height:40px; object-fit: cover;" alt="Avatar" />
                                    <div>
                                        <h6
                                            style="max-width:150px;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;">
                                            {{ $i->firstname }} {{ $i->lastname }}</h6>
                                        <p class="email">{{ $i->email }}</p>
                                    </div>
                                </div>
                                {{-- <a href="" class="x-a">
                                <i class="fas fa-times"></i>
                            </a> --}}
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="modal-footer">
                    {{-- <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Check all
                        </label>
                    </div> --}}
                    <button class="btn-add" data-bs-toggle="modal" data-bs-target="#findStudent">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
@if (session('theoritical'))
    <script>
        Toastify({
            text: "{{ session('theoritical') }}",
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
<script>
    let data = JSON.parse(`<?php echo json_encode($available); ?>`);
    data.forEach(element => {
        $('#find_student_container').append(`
        <div class="d-flex align-items-center justify-content-between" style="gap: 10px;padding:5px 0;margin-bottom:10px">
                        <div class="d-flex align-items-center" style="gap: 10px;">
                            <input type="checkbox" name="students[]" value="${element.session_id}"
                                    class="form-check-input" style="margin-right: 10px">
                            <img src="/${element.profile_image}" class="rounded-circle"
                                style="width: 40px;height:40px; object-fit: cover;" alt="Avatar" />
                            <div>
                                <h6
                                    style="max-width:150px;
                        white-space: nowrap;
                        overflow: hidden;
                        text-overflow: ellipsis;">
                        ${element.firstname} ${element.lastname}</h6>
                                <p class="email">${element.email}</p>
                            </div>
                        </div>
                        {{-- <a href="" class="x-a">
                            <i class="fas fa-times"></i>
                        </a> --}}
                    </div>
        
        `);
    });
</script>
@include(SchoolFileHelper::$footer)
