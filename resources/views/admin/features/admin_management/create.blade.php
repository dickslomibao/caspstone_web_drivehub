@include('admin.includes.header', ['title' => 'Create a new Admin'])
<style>
    .btn-add {
        margin-top: 10px;
        padding: 0 50px;
        height: 44px;
        background: var(--secondaryBG);
        color: white;
        border: none;
        outline: none;
        font-size: 16px;
        font-weight: 500;
        border-radius: 10px;
    }
</style>

<div class="container-fluid" style="padding: 20px;margin-top:60px">
    <div class="row">
        <div class="col-12">

            <form action="" method="post" id="admin_form">
                <div class="col-12">
                    <h6 style="margin-bottom: 15px">Personal Information</h6>
                </div>
                <div class="card" style="padding: 20px">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="firstname" class="form-label">Firstname: <i id="check-firstname" class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter firstname..." required />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="middlename" class="form-label">Middlename: <i id="check-middlename" class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Enter middlename..." required />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="lastname" class="form-label">Lastname: <i id="check-lastname" class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter lastname..." required />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="sex" class="form-label">Sex: <i id="check-sex" class="fa-solid fa-check check-label" style=""></i></label>
                                <select class="form-select" name="sex" id="sex" aria-label="Default select example" required>
                                    <option selected value="" style="display:none">Select sex</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="birthdate" class="form-label">Birthdate: <i id="check-birthdate" class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="date" class="form-control" id="birthdate" name="birthdate" placeholder="Select birthdate..." required />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone number <i id="check-phone_number" class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" required placeholder="+639123456789" />
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label for="address" class="form-label">Address <i id="check-address" class="fa-solid fa-check check-label" style=""></i></label>
                                <input class="form-control" required id="address" name="address" placeholder="Enter address..." />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="images" class="form-label">Profile picture: <i id="check-images" class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="file" class="form-control" id="images" name="images" required />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <h6 style="margin: 15px 0">Credentials Information</h6>
                </div>
                <div class="card" style="padding: 20px">
                    <div class="row">
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
                    </div>
                </div>


                <div class="d-flex justify-content-end" style="margin-top:20px">
                    <button class="btn-add">Add Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $.validator.addMethod("mobileNumber", function(value, element) {
            return value.trim().match(/^(09|\+639)\d{9}$/);
        }, jQuery.validator.format("Please enter a valid mobile number."));
        $.validator.addMethod("textOnly", function(value, element) {
            return value.trim().match(/^[A-Za-z ]+$/);
        });
        $("#admin_form").validate({
            highlight: function(element, errorClass, validClass) {
                $("#check-" + element.id).css('display', 'none');
            },
            unhighlight: function(element, errorClass, validClass) {
                $("#check-" + element.id).css('display', 'inline-block');
            },
            rules: {
                firstname: {
                    required: true,
                    textOnly: true,
                },
                middlename: {
                    required: true,
                    textOnly: true,
                },
                lastname: {
                    required: true,
                    textOnly: true,
                },
                birthdate: {
                    required: true,
                },
                sex: {
                    required: true,
                },
                phone_number: {
                    required: true,
                    mobileNumber: true,
                },
                address: {
                    required: true
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
            },
            messages: {
                firstname: {
                    required: "Firstname is required",
                    textOnly: "Firstname is invalid"
                },
                middlename: {
                    required: "Middlename is required",
                    textOnly: "Middlename is invalid"
                },
                lastname: {
                    required: "Lastname is required",
                    textOnly: "Lastname is invalid"
                },
                birthdate: {
                    required: "Please enter your birthdate"
                },
                sex: {
                    required: "Sex is required"
                },
                phone_number: {
                    required: "Phone number is required",
                    mobile_number: "Phone number is invalid",
                },
                address: {
                    required: "Address is required"
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
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('store.admin') }}",
                    contentType: false,
                    processData: false,
                    data: new FormData(form),
                    success: function(response) {
                        if (response.code == 200) {
                            swal({
                                icon: "success",
                                title: 'Admin Successfully Updated',
                                text: " ",
                                timer: 2000,
                                showConfirmButton: false,
                            }).then(function() {
                                window.location.href =
                                    "{{ route('admin.retreive.adminAccounts') }}";
                            });
                        }
                    },
                });
            }
        });
    });
</script>
@include('admin.includes.footer')