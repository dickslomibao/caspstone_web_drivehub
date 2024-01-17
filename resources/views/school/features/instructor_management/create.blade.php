@include(SchoolFileHelper::$header, ['title' => 'Create a new Instuctor'])
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
            <form enctype="multipart/form-data" method="POST" name="firstForm" id="instructor_form" action="{{ route('store.instructor') }}">
                <div class="container-fluid">
                    <div class="row">
                        @csrf
                        <div class="col-12">
                            <div class="col-12" style="margin:10px 0 30px 0">
                                <h6>Personal Information</h6>
                            </div>
                            <div class="card">
                                <div class="row">

                                    <div class="col-lg-4">

                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">Firstname: <i id="check-firstname" class="fa-solid fa-check check-label" style=""></i></label>
                                            <div>
                                                <input type="text" class="form-control" name="firstname" id="firstname" id="firstname" placeholder="Enter firstname..." required />
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="middlename" class="form-label">Middlename:(optional) <i id="check-middlename" class="fa-solid fa-check check-label" style=""></i></label>
                                            <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Enter middlename..." required />
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="lastname" class="form-label">Lastname: <i id="check-lastname" class="fa-solid fa-check check-label" style=""></i></label>
                                            <input type="text" class="form-control" id="lastname" name="lastname" required placeholder="Enter lastname..." />
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="birthdate" class="form-label">Birthdate: <i id="check-birthdate" class="fa-solid fa-check check-label" style=""></i></label>
                                            <input type="date" class="form-control" id="birthdate" name="birthdate" required placeholder="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="sex" class="form-label">Sex: <i id="check-sex" class="fa-solid fa-check check-label" style=""></i></label>
                                            <select class="form-select" name="sex" id="sex" aria-label="Default select example" required>
                                                <option selected value="">Select sex</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="phone_number" class="form-label">Phone number <i id="check-phone_number" class="fa-solid fa-check check-label" style=""></i></label>
                                            <input type="text" class="form-control" id="phone_number" name="phone_number" required placeholder="+639123456789" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address <i id="check-address" class="fa-solid fa-check check-label" style=""></i></label>
                                            <input class="form-control" required id="address" name="address" placeholder="Enter address..." />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="image" class="form-label">Profile picture <i id="check-image" class="fa-solid fa-check check-label" style=""></i></label>
                                        <div class="input-group">

                                            <input type="file" name="image" class="form-control" id="image">
                                            <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                        </div>
                                        <label id="image-error" class="error" for="image" style="display: none"></label>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="image" class="form-label">Valid ID <i id="check-valid_id" class="fa-solid fa-check check-label" style=""></i></label>
                                        <div class="input-group">

                                            <input type="file" name="valid_id" class="form-control" id="valid_id">
                                            <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                        </div>
                                        <label id="image-error" class="error" for="valid_id" style="display: none"></label>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="image" class="form-label">Driver's License <i id="check-license" class="fa-solid fa-check check-label" style=""></i></label>
                                        <div class="input-group">

                                            <input type="file" name="license" class="form-control" id="license">
                                            <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                        </div>
                                        <label id="image-error" class="error" for="license" style="display: none"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12" style="margin: 30px 0">
                                <h6>Account Information</h6>
                            </div>
                            <div class="card">
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
                                <button class="btn-add">Add Instructor</button>
                            </div>

                        </div>
                    </div>
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
            return value.trim() == "" ? true : value.trim().match(/^[A-Za-z ]+$/);
        });

        $.validator.addMethod("validateAge", function(value, element) {
            if (value.trim() == "") {
                return true;
            }

            var inputDate = new Date(value);
            var currentDate = new Date();
            var age = currentDate.getFullYear() - inputDate.getFullYear();
            if (currentDate.getMonth() < inputDate.getMonth() || (currentDate.getMonth() === inputDate.getMonth() && currentDate.getDate() < inputDate.getDate())) {
                age--;
            }

            return age >= 17;
        }, "Please enter a valid date of birth and ensure the age is at least 17 years.");

        $("#instructor_form").validate({
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
                    maxlength: 100,
                },
                middlename: {
                    required: false,
                    textOnly: true,
                    maxlength: 100,
                },
                lastname: {
                    required: true,
                    textOnly: true,
                    maxlength: 100,
                },
                birthdate: {
                    required: true,
                    validateAge: true,
                },
                sex: {
                    required: true,
                },
                phone_number: {
                    required: true,
                    mobileNumber: true,
                    remote: {
                        url: "{{ route('check.unique') }}",
                        type: "POST",
                        data: {
                            type: 'phone_number',
                            data: function() {
                                return $('#phone_number').val();
                            }
                        }
                    }
                },
                address: {
                    required: true
                },
                image: {
                    required: true,
                    accept: "image/*"
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
                    },
                    maxlength: 100,
                    minlength: 5,
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
                valid_id: {
                    required: true,
                    accept: "image/*"
                },
                license: {
                    required: true,
                    accept: "image/*"
                },

            },
            messages: {
                firstname: {
                    required: "Firstname is required",
                    textOnly: "Firstname is invalid"
                },
                middlename: {
                    textOnly: "Middlename is invalid",
                },
                lastname: {
                    required: "Lastname is required",
                    textOnly: "Lastname is invalid"
                },
                birthdate: {
                    required: "Please enter your birthdate",
                    validateAge: "Please enter a valid date of birth and ensure the age is at least 17 years."
                },
                sex: {
                    required: "Sex is required"
                },
                phone_number: {
                    required: "Phone number is required",
                    mobile_number: "Phone number is invalid",
                    remote: "Phone number is already in use"
                },
                address: {
                    required: "Address is required",

                },
                image: {
                    required: "Profile image is required",
                    accept: "Image only is allowed",

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
                valid_id: {
                    required: "Valid ID image is required",
                    accept: "Image only is allowed",

                },
                license: {
                    required: "License image is required",
                    accept: "Image only is allowed",

                },
            },

            submitHandler: function(form) {
                form.submit();
                // $.ajax({
                //     type: "POST",
                //     url: "{{ route('store.instructor') }}",
                //     contentType: false,
                //     processData: false,
                //     data: new FormData(form),
                //     success: function(response) {
                //         if (response.code == 200) {
                //             table.row.add(response.instructor).draw(false);
                //             resetForm();
                //             $('#firstFormModal').modal('hide');
                //         }

                //     },
                // });
            }
        });


    });
</script>
@include(SchoolFileHelper::$footer)