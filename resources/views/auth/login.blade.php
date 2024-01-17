<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
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

        .create-txt {
            font-size: 25px
        }

        body {
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
        }
        .card{
            padding: 40px;
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

    <div class="row justify-content-center">
        {{-- <div class="col-lg-6 right">
            </div> --}}
        <div class="center card">
            <center>
                <div style="margin-bottom: 20px">
                    <img src="/logo/logo.png" width="50" alt="">
                    <img src="/logo/logo-text.png" width="150" alt="">
                </div>
            </center>
            <h3 class="create-txt">Login your account</h3>

            <form id="form">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username or email: <i id="check-username"
                                    class="fa-solid fa-check check-label" style=""></i></label>
                            <input type="text" class="form-control" id="username" name="username" required
                                placeholder="Enter username or email..." />
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="password" class="form-label">Password: <i id="check-password"
                                    class="fa-solid fa-check check-label" style=""></i></label>
                            <input type="password" class="form-control" id="password" name="password" required
                                placeholder="Enter password..." />
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="row" style="margin-bottom:10px">
                            <div class="col-6">
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me">
                                    <p style="text-align:left;font-weight:500;font-size:15px;">
                                        Remember me
                                    </p>
                                </div>
                            </div>
                            <div class="col-6">
                                <p class="" style="text-align:right;font-weight:500;font-size:15px;">
                                    <a href="http://" style="color:rgba(0,0,0,.8);text-decoration:underline">Forgot
                                        password?</a>
                                </p>
                            </div>
                            <div class="col-12">
                                <p class="error-prompt"></p>
                            </div>
                        </div>
                        <button class="btn-auth w-100">Login</button>
                        <p class="text-center mt-4" style="font-weight:500;font-size:15px">Don't have an account? <a
                                href="/register" style="text-decoration:underline">Register now</a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
    <script>
        $("#form").validate({
            rules: {
                username: {
                    required: true,
                },
                password: {
                    required: true,
                }
            },
            messages: {
                username: {
                    required: "Please enter your username or email",

                },
                password: {
                    required: "Password is required",
                },
            },
            submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                    url: "/login",
                    data: {
                        'username_email': $('#username').val(),
                        'password': $('#password').val(),
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.code == 200) {
                            location.href = "/school";
                        } else if (response.code == 205) {
                            location.href = "/admin";
                        } else {
                            $('.error-prompt').css('display', 'block');
                            $('.error-prompt').html(response.message);
                        }
                    }
                });

            }
        });
    </script>
</body>

</html>
