<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot password</title>
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
            font-size: 22px;
            margin-bottom: 10px;
        }

        body {
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: start;
        }

        form {
            max-width: 200px;
        }
        .success{
            color: forestgreen;
            text-align: center;
            margin-bottom: 15px;
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
    <div class="row" style="max-width: 500px;margin-top:80px">
        <center>
            <div style="margin-bottom: 20px">
                <img src="/logo/logo.png" width="55" alt="">
                <img src="/logo/logo-text.png" width="180" alt="">
            </div>
        </center>
        <h3 class="create-txt">Forgot password?</h3>
        <p style="margin-bottom: 20px">We will sent the link where you can reset your password.</p>
        <form id="form" method="POST" action="{{route('reset.password')}}">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-3">
                        <label for="username" class="form-label">Email: <i id="check-email"
                                class="fa-solid fa-check check-label" style=""></i></label>
                        <input type="text" class="form-control" id="email" name="email" required
                            placeholder="Enter email..." />
                    </div>
                </div>
                @if (session('error'))
                    <p class="error">{{session('error')}}</p>
                @endif
                @if (session('success'))
                    <p class="success">{{session('success')}}</p>
                @endif
                <div class="col-12">
                    <button class="btn-auth">Reset</button>
                </div>

            </div>
        </form>
    </div>
    {{-- <script>
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
    </script> --}}
</body>

</html>
