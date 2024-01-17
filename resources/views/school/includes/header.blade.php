<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="shortcut icon" href="/logo/logo.png" type="image/x-icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel="stylesheet" href="{{ asset('css/static.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap5.2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/data_table_bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/messages.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- for file export -->
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css"> --}}
    {{-- <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css"> --}}
    <!-- ending----- for file export -->


    <script src="{{ asset('js/jq.js') }}"></script>
    <script src="{{ asset('js/bootstrap5.2.js') }}"></script>
    <script src="{{ asset('js/data_table.js') }}"></script>
    <script src="{{ asset('js/data_table_bootstrap.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>

    <!-- for file export -->
    {{-- <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script> --}}
    <!-- ending -----for file export -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet"
        type="text/css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link rel="stylesheet" href="{{ asset('css/sidenav.css') }}">
    <link rel="stylesheet" href="https://jsuites.net/v4/jsuites.css" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>


    <script src="{{ asset('js/toast.js') }}"></script>





    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    {{--
    <!-- <script src="{{ asset('jsExportFile/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('jsExportFile/buttons.print.min.js') }}"></script>
    <script src="{{ asset('jsExportFile/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('jsExportFile/jquery-3.7.0.js') }}"></script>
    <script src="{{ asset('jsExportFile/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('jsExportFile/jszip.min.js') }}"></script>
    <script src="{{ asset('jsExportFile/pdfmake.min.js') }}"></script>
    <script src="{{ asset('jsExportFile/vfs_fonts.js') }}"></script> --> --}}



    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const user_current_id = "{{ Auth::user()->schoolid }}";
        var pusher = new Pusher('40178e8c6a9375e09f5c', {
            cluster: 'ap1',
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    "_token": "{{ csrf_token() }}",
                }
            }
        });
    </script>
    <style>
        .jnotification {
            right: 0;
        }

        .jnotification-container {
            background: forestgreen;
        }
    </style>
</head>

<body>

    <div class="side-nav">
        <div>
            {{-- <i class="fa-regular fa-circle-right toggle-half"></i> --}}
            <div class="d-flex align-items-center justify-content-center top">
                <div class="logo">
                    <img src="/logo/logo.png" alt="" height="40">
                    <img src="/logo/logo-text.png" alt="" height="35">
                </div>
                {{-- <h5 id="text-logo">Drive <span class="d">Hub</span></h5> --}}
            </div>

            <div class="container-links">
                <span style="font-size: 12px;font-weight:600;">Analyze</span>

                <ul style="margin:10px 0">
                    <li class="active">
                        <a href="{{ route('schoolDashboard') }}"><i
                                class="fa-solid fa-chart-pie"></i><span>Dashboard</span></a>
                    </li>
                    <li class=" {{ request()->routeIs('index.reports') ? 'selected-route' : '' }}">
                        <a href="{{ route('index.reports') }}"><i
                                class="fal fa-signal-alt-3"></i><span>Reports</span></a>
                    </li>


                    <li class="{{ request()->routeIs('index.calendar') ? 'selected-route' : '' }}">
                        <a href="{{ route('index.calendar') }}">

                            @if (request()->routeIs('index.calendar'))
                                <i class="fas fa-calendar-alt"></i>
                            @else
                                <i class="far fa-calendar-alt"></i>
                            @endif

                            <span>Calendar</span>
                        </a>
                    </li>
                </ul>
                <span style="font-size: 12px;font-weight:600;">Operation</span>

                <ul style="margin: 10px 0">
                    <li class=" {{ request()->routeIs('index.theoritical') ? 'selected-route' : '' }}">
                        <a href="{{ route('index.theoritical') }}">
                            @if (request()->routeIs('index.theoritical'))
                                <i class="fas fa-users-class"></i>
                            @else
                                <i class="far fa-users-class"></i>
                            @endif

                            <span>Theoritical
                                Schedules</span>
                        </a>
                    </li>
                    {{-- <li class=" {{ request()->routeIs('availed.schoolview') ? 'selected-route' : '' }}">
                    <a href="{{ route('availed.schoolview') }}"><i class="fa-solid fa-bag-shopping"></i><span>Orders
                            and payment</span></a>
                    </li> --}}
                    <li class=" {{ request()->routeIs('index.availedcourse') ? 'selected-route' : '' }}">
                        <a href="{{ route('index.availedcourse') }}">
                            @if (request()->routeIs('index.availedcourse'))
                                <i class="fas fa-hands-heart"></i>
                            @else
                                <i class="far fa-hands-heart"></i>
                            @endif
                            <span>
                                Availed Courses
                            </span>
                        </a>
                    </li>
                    <li class=" {{ request()->routeIs('index.order') ? 'selected-route' : '' }}">
                        <a href="{{ route('index.order') }}">
                            @if (request()->routeIs('index.order'))
                                <i class="fas fa-bags-shopping"></i>
                            @else
                                <i class="far fa-bags-shopping"></i>
                            @endif
                            <span>
                                Orders and payment
                            </span>
                        </a>
                    </li>
                    <li class=" {{ request()->routeIs('index.tracking') ? 'selected-route' : '' }}">
                        <a href="{{ route('index.tracking') }}">
                            @if (request()->routeIs('index.tracking'))
                                <i class="fas fa-map-marked-alt"></i>
                            @else
                                <i class="far fa-map-marked-alt"></i>
                            @endif
                            <span>
                                Realtime Tracking
                            </span>
                        </a>
                    </li>
                    <li class=" {{ request()->routeIs('index.reported') ? 'selected-route' : '' }}">
                        <a href="{{ route('index.reported') }}">
                            @if (request()->routeIs('index.reported'))
                                <i class="fas fa-flag-alt"></i>
                            @else
                                <i class="far fa-flag-alt"></i>
                            @endif
                            <span>
                                Reported Instructor
                            </span>
                        </a>
                    </li>
                    <li class=" {{ request()->routeIs('index.sreport') ? 'selected-route' : '' }}">
                        <a href="{{ route('index.sreport') }}">
                            @if (request()->routeIs('index.sreport'))
                                <i class="fas fa-calendar-times"></i>
                            @else
                                <i class="far fa-calendar-times"></i>
                            @endif
                            <span>
                                Schedule report
                            </span>
                        </a>
                    </li>
                </ul>
                <span style="font-size: 12px;font-weight:600;">Management</span>
                <ul style="margin-top: 10px">

                    <li class=" {{ request()->routeIs('index.instructor') ? 'selected-route' : '' }}">
                        <a href="{{ route('index.instructor') }}">
                            @if (request()->routeIs('index.instructor'))
                                <i class="fas fa-chalkboard-teacher"></i>
                            @else
                                <i class="far fa-chalkboard-teacher"></i>
                            @endif
                            <Span>Instructor</Span>
                        </a>
                    </li>
                    <li class=" {{ request()->routeIs('index.student') ? 'selected-route' : '' }}">
                        <a href="{{ route('index.student') }}">
                            @if (request()->routeIs('index.student'))
                                <i class="fas fa-users"></i>
                            @else
                                <i class="far fa-users"></i>
                            @endif
                            <span>Students</span>
                        </a>
                    </li>
                    <li class=" {{ request()->routeIs('index.vehicles') ? 'selected-route' : '' }}">
                        <a href="{{ route('index.vehicles') }}">

                            @if (request()->routeIs('index.vehicles'))
                                <i class="fas fa-car"></i>
                            @else
                                <i class="far fa-car"></i>
                            @endif

                            <span>Vehicles</span>
                        </a>
                    </li>

                    <li class=" {{ request()->routeIs('index.courses') ? 'selected-route' : '' }}">
                        <a href="{{ route('index.courses') }}">
                            @if (request()->routeIs('index.courses'))
                                <i class="fas fa-hand-holding-heart"></i>
                            @else
                                <i class="far fa-hand-holding-heart"></i>
                            @endif
                            <span>Courses</span>
                        </a>
                    </li>
                    <li class=" {{ request()->routeIs('index.promo') ? 'selected-route' : '' }}">
                        <a href="{{ route('index.promo') }}">

                            @if (request()->routeIs('index.promo'))
                                <i class="fas fa-hand-heart"></i>
                            @else
                                <i class="far fa-hand-heart"></i>
                            @endif
                            <span>Promo</span>
                        </a>
                    </li>
                    <li class=" {{ request()->routeIs('index.staff') ? 'selected-route' : '' }}">
                        <a href="{{ route('index.staff') }}">
                            @if (request()->routeIs('index.staff'))
                                <i class="fas fa-person-carry"></i>
                            @else
                                <i class="far fa-person-carry"></i>
                            @endif
                            <span>Staff</span>
                        </a>
                    </li>
                    <li class=" {{ request()->routeIs('progress.index') ? 'selected-route' : '' }}">
                        <a href="{{ route('progress.index') }}">

                            @if (request()->routeIs('progress.index'))
                                <i class="fas fa-tasks-alt"></i>
                            @else
                                <i class="far fa-tasks-alt"></i>
                            @endif


                            <span>Progress</span>
                        </a>
                    </li>

                    <li
                        class=" {{ request()->routeIs('index.question') || request()->routeIs('create.question') ? 'selected-route' : '' }}">
                        <a href="{{ route('index.question') }}">
                            @if (request()->routeIs('index.question'))
                                <i class="fas fa-question"></i>
                            @else
                                <i class="far fa-question"></i>
                            @endif
                            <span>Questions</span>
                        </a>
                    </li>

                    <li class=" {{ request()->routeIs('accreditation.index') ? 'selected-route' : '' }}">
                        <a href="{{ route('accreditation.index') }}">
                            @if (request()->routeIs('accreditation.index'))
                                <i class="fas fa-school"></i>
                            @else
                                <i class="far fa-school"></i>
                            @endif
                            <span>Accreditation</span>
                        </a>
                    </li>

                    <li class=" {{ request()->routeIs('index.log') ? 'selected-route' : '' }}">
                        <a href="{{ route('index.log') }}">
                            @if (request()->routeIs('index.log'))
                                <i class="fas fa-paste"></i>
                            @else
                                <i class="fal fa-paste"></i>
                            @endif
                            <span>Logs</span>
                        </a>
                    </li>
                    {{-- <li class="" id="more" style="cursor: pointer">
                    <a role="button"><i class="fa-solid fa-caret-down"></i><span
                            style="font-size: 12px">More</span></a>
                </li> --}}
                </ul>
            </div>
        </div>
        {{-- <div class="bottom-section">
            <ul>
                <li class="">
                    <a href="#"><i class="fa-solid fa-gear"></i><span>Settings</span></a>
                </li>
                <li class="">
                    <a href="/logout"><i class="fa-solid fa-right-from-bracket"></i><span>Logout</span></a>
                </li>
            </ul>
        </div> --}}
    </div>
    <div class="right-content">
        <div class="header">
            <div class="d-flex align-items-center" style="gap: 15px">
                <i class="far fa-bars" style="font-size: 20px;display:none" id="toggle-burger"></i>
                <h5 class="title">{{ $title }}</h5>
            </div>
            <div class="d-flex align-items-center" style="gap: 30px">
                <div class="custom-badge" data-bs-toggle="modal" data-bs-target="#tourguide">
                    <i class="far fa-question-square"></i>
                    {{-- <span class="">8</span> --}}
                </div>

                <div class="custom-badge" onclick="location.href='/logout'">
                    <i class="far fa-sign-out"></i>
                    {{-- <span class="">8</span> --}}
                </div>
                <div class="custom-badge" onclick="location.href='/school/messages'" style="cursor: pointer">
                    <i class="far fa-envelope"></i>
                    {{-- <span class="">9+</span> --}}
                </div>

                <div class="d-flex align-items-center " style="gap: 10px" id="">
                    <img src="/{{ Auth::user()->profile_image }}" class="rounded-circle"
                        style="width: 30px;height:30px" alt="Avatar" />

                    <div class="profile-name" onclick="location.href='/school/profile';">
                        @auth
                            @if (Auth::user()->type == 1)
                                {{ Auth::user()->info->name }}
                            @endif
                            @if (Auth::user()->type == 4)
                                {{ Auth::user()->info->firstname }} {{ Auth::user()->info->lastname }}
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade modal-lg" id="tourguide" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Quick tour</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Welcome to DriveHub - Your Ultimate Driving School Management System
                            Thank you for choosing DriveHub, your comprehensive solution for managing every aspect of
                            your
                            driving school. DriveHub is designed to streamline your experience. Let's take a quick tour
                            of
                            its key features:
                        </p>
                        <h6 style="margin: 10px 0">
                            Step: 1 - Staff management
                        </h6>
                        <p>
                            Create your staff where in you can control their access.
                        </p>
                        <h6 style="margin: 10px 0">
                            Step: 2 - Instructor Management
                        </h6>
                        <p>
                            Create Instructor’s Account by providing personal information and important details.
                        </p>
                        <h6 style="margin: 10px 0">
                            Step: 3 - Vehicle Management
                        </h6>
                        <p>
                            Add and manage vehicle assets including the vehicle’s information.
                        </p>
                        <h6 style="margin: 10px 0">
                            Step: 4 - Course Management
                        </h6>
                        <p>
                            Efficiently Manage driving school courses by adding course name, description and course
                            thumbnail including selecting course progress.
                        </p>
                        <h6 style="margin: 10px 0">
                            Step: 5 - Promo Management
                        </h6>
                        <p>
                            Provides flexibility in any kind of events by creating a low-cost promo to efficiently
                            promote the driving school.
                        </p>
                        <h6 style="margin: 10px 0">
                            Step: 6 - Student Management
                        </h6>
                        <p>
                            Manually Enroll student in DriveHub by providing student’s information and login
                            credentials.
                        </p>
                        <h6 style="margin: 10px 0">
                            Step: 7 - Promo Management
                        </h6>
                        <p>
                            Provides flexibility in any kind of events by creating a low-cost promo to efficiently
                            promote the driving school.
                        </p>
                        <h6 style="margin: 10px 0">
                            Step: 8 - Theoretical Schedules
                        </h6>
                        <p>
                            Create a theoretical class schedule, provide the course start date and end date, and find
                            instructors’ availability.
                        </p>
                    </div>

                </div>
            </div>
        </div>

        {{-- <script>
            $(document).ready(function() {
                $('#tourguide').modal('show');
            });
        </script> --}}
