<body>


    <div class="side-nav">
        <div>
            <i class="fa-regular fa-circle-right toggle-half"></i>
            <div class="d-flex align-items-center justify-content-center top">
                <div class="logo">
                    <img src="/logo1.png" alt="" width="30" height="30">
                    <h4 class="text-logo"></h4>
                </div>
                <h5 id="text-logo">Drive <span class="d">Hub</span></h5>
            </div>

            <div class="container-links">
                <span style="font-size: 12px;font-weight:600;">Analyze</span>

                <ul style="margin:10px 0">
                    <li class="active">
                        <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-chart-pie"></i><span>Dashboard</span></a>
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



                    <li class=" {{ request()->routeIs('index.theoritical') ? 'selected-route' : '' }}">
                        <a href="{{ route('index.theoritical') }}">
                            @if (request()->routeIs('index.theoritical'))
                            <i class="fa-solid fa-bullhorn"></i>
                            @else
                            <i class="fa-solid fa-bullhorn"></i>
                            @endif

                            <span>Announcements</span>
                        </a>
                    </li>

                    <li class=" ">
                        <a href="{{ route('index.theoritical') }}">
                            <i class="fa-solid fa-list-check"></i>
                            <span>
                                Terms & Condition
                            </span>
                        </a>
                    </li>






                </ul>

                <span style="font-size: 12px;font-weight:600;">Management</span>
                <ul style="margin-top: 10px">

                    <li class=" {{ request()->routeIs('admin.drivingschool') ? 'selected-route' : '' }}">
                        <a href="{{ route('admin.drivingschool') }}"><i class="fa-solid fa-school-flag"></i><Span>Driving School</Span></a>
                    </li>
                    <li class=" {{ request()->routeIs('admin.student') ? 'selected-route' : '' }}">
                        <a href="{{ route('admin.student') }}"> <i class="fa-solid fa-users"></i><span>Students</span></a>
                    </li>



                    {{-- <li class="" id="more" style="cursor: pointer">
                    <a role="button"><i class="fa-solid fa-caret-down"></i><span
                            style="font-size: 12px">More</span></a>
                </li> --}}
                </ul>


                <ul id="more-link" style="display: none">
                    <li class="">
                        <a href="{{ route('progress.index') }}"><i class="fa-solid fa-list-check"></i><span>Progress</span></a>
                    </li>
                    <li class=" {{ request()->routeIs('index.staff') ? 'selected-route' : '' }}">
                        <a href="{{ route('index.staff') }}"><i class="fa-solid fa-bag-shopping"></i><span>Staff</span></a>
                    </li>
                    {{-- <li class="">
                    <a href="#"><i class="fa-solid fa-note-sticky"></i><span>Reviewers</span></a>
                </li>
                <li class="">
                    <a href="#"><i class="fa-solid fa-newspaper"></i><span>News and event</span></a>
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
            <h5 class="title">{{ $title }}</h5>
            <div class="d-flex align-items-center" style="gap: 30px">
                <div class="custom-badge">
                    <i class="fal fa-bell"></i>
                    <span class="">8</span>
                </div>
                <div class="custom-badge">
                    <i class="fal fa-envelope"></i>
                    <span class="">9+</span>
                </div>
                |
                <div class="d-flex align-items-center" style="gap: 10px">
                    <img src="https://media.sproutsocial.com/uploads/2022/06/profile-picture.jpeg" class="rounded-circle" style="width: 30px;height:30px" alt="Avatar" />

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