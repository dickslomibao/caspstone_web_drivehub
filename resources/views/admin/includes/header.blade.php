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
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css"> -->
    <!-- ending----- for file export -->


    <script src="{{ asset('js/jq.js') }}"></script>
    <script src="{{ asset('js/bootstrap5.2.js') }}"></script>
    <script src="{{ asset('js/data_table.js') }}"></script>
    <script src="{{ asset('js/data_table_bootstrap.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>

    <!-- for file export -->
    <!-- <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript"
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
        src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script> -->
    <!-- ending -----for file export -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet"
        type="text/css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link rel="stylesheet" href="{{ asset('css/sidenav.css') }}">






    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



    <!-- <script src="{{ asset('jsExportFile/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('jsExportFile/buttons.print.min.js') }}"></script>
    <script src="{{ asset('jsExportFile/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('jsExportFile/jquery-3.7.0.js') }}"></script>
    <script src="{{ asset('jsExportFile/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('jsExportFile/jszip.min.js') }}"></script>
    <script src="{{ asset('jsExportFile/pdfmake.min.js') }}"></script>
    <script src="{{ asset('jsExportFile/vfs_fonts.js') }}"></script> -->



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

            </div>

            <div class="container-links">
                <span style="font-size: 12px;font-weight:600;">Analyze</span>

                <ul style="margin:10px 0">
                    <li class="active">
                        <a href="{{ route('admin.dashboard') }}"><i
                                class="fa-solid fa-chart-pie"></i><span>Dashboard</span></a>
                    </li>


                </ul>


                <span style="font-size: 12px;font-weight:600;">Operation</span>

                <ul style="margin: 10px 0">



                    <li class=" {{ request()->routeIs('admin.pendingSchool') ? 'selected-route' : '' }}">
                        <a href="{{ route('admin.pendingSchool') }}">
                            <i class="fa-solid fa-school-circle-exclamation"></i>
                            <span>
                                Pending Application
                            </span>
                        </a>
                    </li>

                    {{-- 

                    <li class=" {{ request()->routeIs('index.theoritical') ? 'selected-route' : '' }}">
                        <a href="{{ route('index.theoritical') }}">
                            @if (request()->routeIs('index.theoritical'))
                                <i class="fa-solid fa-bullhorn"></i>
                            @else
                                <i class="fa-solid fa-bullhorn"></i>
                            @endif

                            <span>Announcements</span>
                        </a>
                    </li> --}}

                    <li class=" {{ request()->routeIs('index.terms') ? 'selected-route' : '' }}">
                        <a href="{{ route('index.terms') }}">
                            <i class="fa-solid fa-list-check"></i>
                            <span>
                                Terms of Services
                            </span>
                        </a>
                    </li>

                    <li class=" {{ request()->routeIs('index.privacy') ? 'selected-route' : '' }}">
                        <a href="{{ route('index.privacy') }}">
                            <i class="fa-solid fa-building-shield"></i>
                            <span>
                                Privacy Policy
                            </span>
                        </a>
                    </li>

                    <li class=" {{ request()->routeIs('index.identification') ? 'selected-route' : '' }}">
                        <a href="{{ route('index.identification') }}">
                            <i class="fa-solid fa-address-card"></i>
                            <span>
                                Identification Card
                            </span>

                        </a>
                    </li>



                </ul>

                <span style="font-size: 12px;font-weight:600;">Management</span>
                <ul style="margin-top: 10px">

                    <li class=" {{ request()->routeIs('admin.drivingschool') ? 'selected-route' : '' }}">
                        <a href="{{ route('admin.drivingschool') }}"><i class="fa-solid fa-school-flag"></i><Span>View
                                Driving School</Span></a>
                    </li>
                    <!-- <li class=" {{ request()->routeIs('admin.student') ? 'selected-route' : '' }}">
                        <a href="{{ route('admin.student') }}"> <i class="fa-solid fa-users"></i><span>Students</span></a>
                    </li> -->
                    <li class=" {{ request()->routeIs('admin.retreive.adminAccounts') ? 'selected-route' : '' }}">
                        <a href="{{ route('admin.retreive.adminAccounts') }}"> <i
                                class="fa-solid fa-users"></i><span>Admin</span></a>
                    </li>

                    <li class=" {{ request()->routeIs('admin.log.index') ? 'selected-route' : '' }}">
                        <a href="{{ route('admin.log.index') }}">
                            @if (request()->routeIs('admin.log.index'))
                            <i class="fa-solid fa-clipboard"></i>
                            @else
                            <i class="fa-solid fa-clipboard"></i>
                            @endif
                            <span>Logs</span>
                        </a>
                    </li>


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
                <div class="custom-badge" onclick="location.href='/logout'">
                    <i class="far fa-sign-out"></i>
                    {{-- <span class="">8</span> --}}
                </div>
                {{-- <div class="custom-badge" onclick="location.href='/school/messages'" style="cursor: pointer">
                    <i class="far fa-envelope"></i>
                    <span class="">9+</span>
                </div> --}}

                {{-- <div class="d-flex align-items-center " style="gap: 10px" id="">
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
                </div> --}}
            </div>
        </div>
