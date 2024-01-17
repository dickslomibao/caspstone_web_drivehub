{{-- <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
@csrf

<!-- Name -->
<div>
    <x-input-label for="name" :value="__('Name')" />
    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus
        autocomplete="name" />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<!-- Email Address -->
<div class="mt-4">
    <x-input-label for="email" :value="__('Email')" />
    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
        autocomplete="username" />
    <x-input-error :messages="$errors->get('email')" class="mt-2" />
</div>

<!-- Password -->
<div class="mt-4">
    <x-input-label for="password" :value="__('Password')" />

    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
        autocomplete="new-password" />

    <x-input-error :messages="$errors->get('password')" class="mt-2" />
</div>

<!-- Confirm Password -->
<div class="mt-4">
    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation"
        required autocomplete="new-password" />

    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
</div>

<div class="flex items-center justify-end mt-4">
    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        href="{{ route('login') }}">
        {{ __('Already registered?') }}
    </a>

    <x-primary-button class="ml-4">
        {{ __('Register') }}
    </x-primary-button>
</div>
</form>
</x-guest-layout> --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="shortcut icon" href="/logo/logo.png" type="image/x-icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/static.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap5.2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <script src="{{ asset('js/jq.js') }}"></script>
    <script src="{{ asset('js/bootstrap5.2.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

    <style>
        #map {
            height: 400px;
            width: 100%;
        }

        body {
            height: 100vh;
            display: grid;
            place-items: center;
            font-family: 'Roboto', sans-serif;
        }

        .form-label {
            font-weight: 500;
        }

        .dropdown-item {
            display: inline;
            color: blue;
            /* Ensure the class does not force a new line */
        }
    </style>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</head>

<body>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6 right d-sm-none d-md-none d-lg-block"
                style="background: url('/logo/img1.JPG') center/cover var(--primaryBG); position: relative;">
                <div class="overlay"
                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.9);">
                </div>
                <div class="d-flex align-items-center justify-content-center"
                    style="height: 100vh; flex-direction: column; position: relative; z-index: 1;">
                    <div style="background: white; padding: 20px; border-radius: 20px;">
                        <div class="d-flex align-items-center" style="column-gap: 10px;">
                            <img src="/logo/logo.png" alt="" height="55">
                            {{-- <img src="/logo/logo-text.png" alt="" height="50"> --}}
                        </div>
                    </div>
                    <h3 style="color: white; margin-top: 20px;">Steer Your Learning Journey</h3>
                </div>
            </div>
            <div class="col-lg-6">
                <div style="padding:30px 40px 0 40px">


                    <h4 style="margin:30px 0;">Register as Driving School</h4>

                    <form id="form">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">School Name: <i id="check-name"
                                            class="fa-solid fa-check check-label" style=""></i></label>
                                    <input placeholder="School name..." type="text" name="name" id="name"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Address: <i id="check-address"
                                            class="fa-solid fa-check check-label" style=""></i></label>
                                    <input type="text" placeholder="Addres..." name="address" id="address"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username: <i id="check-username"
                                            class="fa-solid fa-check check-label" style=""></i></label>
                                    <input type="text" class="form-control" id="username" name="username" required
                                        placeholder="Enter username..." />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email: <i id="check-email"
                                            class="fa-solid fa-check check-label" style=""></i></label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="Enter email..." />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password: <i id="check-password"
                                            class="fa-solid fa-check check-label" style=""></i></label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        required placeholder="Enter password..." />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm
                                        Password: <i id="check-password_confirmation"
                                            class="fa-solid fa-check check-label" style=""></i></label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" required placeholder="Enter password..." />
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="image" class="form-label">Profile Picture: <i id="check-image"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" accept="image/*" id="image"
                                        name="image">
                                    <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                </div>
                                <label id="agree-image" class="error" for="image" style="display:none"></label>

                            </div>
                            {{-- <div class="col-lg-12">
                            <div class="mb-3">
                              
                                <br>
                                <input type="file" class="form-controls" id="image" name="image"
                                    required />
                                <br>
                                <label id="agree-image" class="error" for="image" style="display:none"></label>
                            </div>
                        </div> --}}
                            <div class="col-12" style="margin: 10px 0">
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="agree" name="agree">
                                    <p style="white-space: nowrap;">I accept the <a href="#"
                                            class="dropdown-item terms">Terms of Services</a> as well <a
                                            href="#" class="dropdown-item privacy">Privacy Policy</a></p>



                                    <label id="agree-error" class="error" for="agree"
                                        style="display:none"></label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button class="btn-auth w-100">Register</button>
                                <p class="text-center mt-4">Already have an account? <a href="/login">Login now</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fs-5" id="exampleModalLabel">Select Your Location</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="map"></div>
                    <p style="margin-top: 10px" id="display-address"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal terms -->

    <div class="modal fade" id="terms_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="terms_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="terms_modalLabel">Drivehub Terms of Services
                        Schools</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-11 mx-auto">
                        @php $count = 1; @endphp
                        @if (count($terms))
                            <ol>
                                @foreach ($terms as $data)
                                    <li><b>{{ $count }} {{ $data->title }}</b> <br>

                                        <p style="text-align: justify;">&#8226 {{ $data->description }}</p>
                                    </li>

                                    @php $count++; @endphp
                                @endforeach
                            </ol>
                        @endif

                        <br>

                        Thank you for choosing DriveHub! By using our services, you agree to abide by these Terms of
                        Service. If you have any questions or concerns, please don't hesitate to contact our support
                        team. Safe travels and enjoy the journey with DriveHub!
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div>


    <!-- modal privacy -->
    <div class="modal fade" id="privacy_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="privacy_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="privacy_modalLabel">Drivehub Terms of Services
                        Schools</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-11 mx-auto">
                        @php $count = 1; @endphp
                        @if (count($privacy))
                            <ol>
                                @foreach ($privacy as $data)
                                    <li><b>{{ $count }} {{ $data->title }}</b> <br>

                                        <p style="text-align: justify;">&#8226 {{ $data->description }}</p>
                                    </li>

                                    @php $count++; @endphp
                                @endforeach
                            </ol>
                        @endif

                        <br>

                        Thank you for choosing DriveHub. Your trust is important, and by using our services, you agree
                        to our Privacy Policy, ensuring your information is handled with the utmost care.
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC85qXT_Yw5dwax9Rk9K62DLsxM9vVQWB4&callback=initMap&v=weekly"
        defer></script>
    <script>
        const addressInput = document.querySelector("#address");
        let infoWindow;
        let geocoder;
        let map;
        let address;
        let lat;
        let long;
        addressInput.addEventListener('click', function() {
            $('#exampleModal').modal('show');
        });

        function initMap() {
            const myLatlng = {
                lat: 16.566233,
                lng: 121.262634
            };
            geocoder = new google.maps.Geocoder();
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 7,
                center: myLatlng,
            });
            const locationButton = document.createElement("button");

            locationButton.textContent = "Pan to Current Location";
            locationButton.classList.add("custom-map-control-button");
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);

            locationButton.addEventListener("click", () => {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        async (position) => {
                                const pos = {
                                    lat: position.coords.latitude,
                                    lng: position.coords.longitude,
                                };
                                lat = pos.lat;
                                long = pos.lng;
                                await geocode({
                                    location: pos
                                });
                            },
                            () => {
                                handleLocationError(true, infoWindow, map.getCenter());
                            },
                    );
                } else {
                    handleLocationError(false, infoWindow, map.getCenter());
                }
            });
            map.addListener("click", (mapsMouseEvent) => {
                const location = mapsMouseEvent.latLng;
                lat = location.lat();
                long = location.lng();
                geocode({
                    location: location
                });
            });
        }

        async function geocode(request) {
            await geocoder
                .geocode(request)
                .then((result) => {
                    const {
                        results
                    } = result;
                    const position = request.location;
                    address = result.results[1].formatted_address;
                    console.log(result);
                    if (infoWindow) {
                        infoWindow.close();
                    }
                    infoWindow = new google.maps.InfoWindow({
                        position: position,
                    });

                    infoWindow.setContent(
                        address,
                    );
                    console.log(lat);
                    console.log(long);
                    infoWindow.open(map);
                    map.setCenter(position);
                    map.setZoom(15);
                    $('#display-address').html("Selected Address: " + address);
                    $('#address').val(address);
                })
                .catch((e) => {
                    alert("Geocode was not successful for the following reason: " + e);
                });
        }
        window.initMap = initMap;
    </script>
    <script>
        $("#form").validate({
            highlight: function(element, errorClass, validClass) {
                $("#check-" + element.id).css('display', 'none');
            },
            unhighlight: function(element, errorClass, validClass) {
                $("#check-" + element.id).css('display', 'inline-block');
            },
            rules: {
                name: {
                    required: true,
                },
                address: {
                    required: true,
                },
                username: {
                    required: true,
                    remote: {
                        url: "{{ route('check.unique') }}",
                        type: "POST",
                        data: {
                            type: 'username',
                            data: function() {
                                return $('#username').val();
                            }
                        }
                    }
                },
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "{{ route('check.unique') }}",
                        type: "POST",
                        data: {
                            type: 'email',
                            data: function() {
                                return $('#email').val();
                            }
                        }
                    }
                },
                password: {
                    required: true,
                    minlength: 8,
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                },
                agree: {
                    required: true,
                },
                image: {
                    required: true,
                }
            },
            messages: {
                name: {
                    required: 'School name is required',
                },
                address: {
                    required: 'Address is required',
                },
                username: {
                    required: "Please enter your username",
                    minlength: "Username must be at least 5 characters",
                    remote: "This username is already in use"
                },
                email: {
                    required: "Email address is required",
                    email: "Please enter a valid email address",
                    remote: "This email address is already in use"
                },
                password: {
                    required: "Password is required",
                },
                "password_confirmation": {
                    required: "Comfirm password is required",
                    equalTo: "Passwords did not match"
                },
                agree: {
                    required: "Agree with terms and conditon to continue."
                },
                image: {
                    required: 'School profile picture is required.'
                }
            },
            submitHandler: function(form) {
                const formData = new FormData(form);
                formData.append('latitude', lat);
                formData.append('longitude', long);
                $.ajax({
                    type: "POST",
                    url: "{{ route('register.school') }}",
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        if (response.message == 'Added Successfully') {
                            location.href = "/school";
                        }
                        console.log(response);
                    }
                });

            }
        });

        $(document).on('click', '.terms', function() {
            $('#terms_modal').modal('show');

        });

        $(document).on('click', '.privacy', function() {
            $('#privacy_modal').modal('show');

        });
    </script>
</body>

</html>
