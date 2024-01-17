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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/static.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap5.2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <script src="{{ asset('js/jq.js') }}"></script>
    <script src="{{ asset('js/bootstrap5.2.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <style>
        #map {
            height: 400px;
            width: 100%;
        }

        body {
            height: 100vh;
            display: grid;
            place-items: center;
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
            {{-- <div class="col-lg-6 right">
            </div> --}}
            <div class="col-lg-6 left">
                <h2 class="logo">DriveHub</h2>

                <h5 class="create-txt">Create an account for Driving School</h5>

                <form id="form">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                            <input type="hidden" value="1" id="status" name="status"/>
                                <label for="" class="form-label">School Name: <i id="check-name" class="fa-solid fa-check check-label" style=""></i></label>
                                <input placeholder="School name..." type="text" name="name" id="name" class="form-control">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="" class="form-label">Address: <i id="check-address" class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="text" placeholder="Addres..." name="address" id="address" class="form-control">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username: <i id="check-username" class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="text" class="form-control" id="username" name="username" required placeholder="Enter username..." />
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email: <i id="check-email" class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Enter email..." />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password: <i id="check-password" class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="password" class="form-control" id="password" name="password" required placeholder="Enter password..." />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm
                                    Password: <i id="check-password_confirmation" class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Enter password..." />
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="image" class="form-label">Profile Picture: <i id="check-image" class="fa-solid fa-check check-label" style=""></i></label>
                                <br>
                                <input type="file" class="form-controls" id="image" name="image" required />
                                <br>
                                <label id="agree-image" class="error" for="image" style="display:none"></label>

                            </div>
                        </div>
                        <!-- <div class="col-12" style="margin: 10px 0">
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="agree" name="agree">
                                <p>I accept the <a href="#">Terms of Services</a> as well <a
                                        href="#">Privacy Policy</a></p>
                                <label id="agree-error" class="error" for="agree" style="display:none"></label>
                            </div>
                        </div> -->
                        <div class="col-lg-12">
                            <button class="btn-auth w-100">Register</button>
                            <!-- <p class="text-center mt-4">Already have an account? <a href="#">Login now</a></p> -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fs-5" id="exampleModalLabel">Select Your Location</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="map"></div>
                    <p style="margin-top: 10px" id="display-address"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAX4w_kaQur97TeoMBsuVgALo37yqpbBco&callback=initMap&v=weekly" defer></script>
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
            //create button
            locationButton.textContent = "Pan to Current Location";
            locationButton.classList.add("custom-map-control-button");
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);
            //event of created button
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
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                },
                // agree: {
                //     required: true,
                // },
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
                // agree: {
                //     required: "Agree with terms and conditon to continue."
                // },
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
                    url: "{{ route('admin.register.school') }}",
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        //console.log(response);
                        swal({
                            icon: "success",
                            title: 'Driving School Successfully Registered',
                            text: " ",
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(function() {
                            window.location.href = "{{ route('admin.drivingschool') }}";
                        });
                    }
                });

            }
        });
    </script>
</body>

</html>