@include(SchoolFileHelper::$header, ['title' => 'Student Profile'])
<style>
    .button-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center
    }

    .view-btn {
        background-color: var(--secondaryBG);
        border: none;
        color: #fff;
        width: 100%;
        padding: 5px 10px;
        margin-top: 15px;
        font-size: 15px;
        border-radius: 5px;
    }
</style>
{{-- @dd($student) --}}
<div class="container-fluid" style="padding: 20px;margin-top:60px">
    <div class="row">
        <div class="col-12">
            <h6 style="margin-bottom:15px">Student Information</h6>
            <div class="card">
                <div class="d-flex align-items-center" style="margin:  0 0 10px 0;column-gap:10px">
                    <img src="/{{ $student->profile_image }}" alt=""
                        style="width: 40px;height:40px;object-fit:cover;border-radius:50%">
                    <div>
                        <h6 style="font-weight: 500">
                            {{ $student->firstname }} {{ $student->middlename }} {{ $student->lastname }}
                        </h6>
                        <p style="font-size: 14px;font-weight:500">
                            {{ $student->email }}
                        </p>
                    </div>
                </div>
                <h6 style="margin-top: 5px">Birthdate: {{ $student->birthdate }}</h6>
                <h6 style="margin-top: 5px">Sex: {{ $student->sex }}</h6>
                <h6 style="margin-top: 5px">Address: {{ $student->address }}</h6>
            </div>

            <h6 style="margin:15px 0">Student Courses</h6>

            <div class="row">
                @forelse ($courses as $course)
                    @php
                        $c = (array) $course;
                    @endphp
                    <div class="col-lg-4 mb-3">
                        <div class="card">
                            <div style="position: relative;width:100%">
                                <img style="object-fit:cover;border-radius:5px" height="200" width="100%"
                                    src="/{{ $c['course_info.thumbnail'] }}">

                                @switch($c['mycourse.status'])
                                    @case(1)
                                        <span style="position: absolute;left:5%;top:5%;border:1px solid white"
                                            class="waiting">Waiting</span>
                                    @break

                                    @case(2)
                                        <span style="position: absolute;left:5%;top:5%;border:1px solid white"
                                            class="started">Started</span>
                                    @break

                                    @case(3)
                                        <span style="position: absolute;left:5%;top:5%;border:1px solid white"
                                            class="Comleted">comleted</span>
                                    @break

                                    @default
                                @endswitch
                            </div>

                            <h6 style="margin:20px 0 5px 0">Course: {{ $c['course_info.name'] }}</h6>

                            <h6 style="margin-bottom: 5px">Duration: {{ $c['mycourse.status'] }} hrs</h6>
                            <h6 style="margin-bottom: 5px">Sessions: {{ $c['mycourse.session'] }}</h6>
                            <h6 style="margin-bottom: 5px">Remarks: {{ $c['mycourse.remarks'] ?? 'waiting' }}</h6>

                            <button class="view-btn" onclick="location.href='/availed/courses/{{ $c['mycourse.id'] }}/view'">
                                View Course
                            </button>
                        </div>
                    </div>
                    @empty
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    @include(SchoolFileHelper::$footer)
