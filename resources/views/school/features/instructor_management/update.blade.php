@include(SchoolFileHelper::$header, ['title' => 'Update Instructor'])
<div class="container-fluid" style="padding: 20px;margin-top:60px">



    <form name="firstForm" id="instructor_form">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-2">
                    <div class="col-12" style="margin:10px 0 30px 0">
                        <h6>Profile Picture</h6>
                    </div>
                    <img class="img-fluid" style="border-radius: 10px" src="/{{($details->profile_image)}}" alt=""
                        srcset="">

                    <div class="mb-3" style="margin-top: 30px">
                        <input type="file" class="form-control" name="image" />
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="col-12" style="margin:10px 0 30px 0">
                        <h6>Personal Information</h6>
                    </div>
                    <div style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;padding:20px;border-radius:20px">
                        <div class="row">

                            <div class="col-lg-4">

                                <div class="mb-3">
                                    <label for="firstname" class="form-label">Firstname: <i id="check-firstname"
                                            class="fa-solid fa-check check-label" style=""></i></label>
                                    <div>
                                        <input type="hidden" class="form-control" name="user_id"
                                            value="{{$details->user_id}}" />
                                        <input type="text" class="form-control" name="firstname"
                                            value="{{$details->firstname}}" id="firstname" id="firstname"
                                            placeholder="Enter firstname..." required />
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="middlename" class="form-label">Middlename:(optional) <i
                                            id="check-middlename" class="fa-solid fa-check check-label"
                                            style=""></i></label>
                                    <input type="text" class="form-control" id="middlename"
                                        value="{{$details->middlename}}" name="middlename"
                                        placeholder="Enter middlename..." required />
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="lastname" class="form-label">Lastname: <i id="check-lastname"
                                            class="fa-solid fa-check check-label" style=""></i></label>
                                    <input type="text" class="form-control" id="lastname" value="{{$details->lastname}}"
                                        name="lastname" required placeholder="Enter lastname..." />
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="birthdate" class="form-label">Birthdate: <i id="check-birthdate"
                                            class="fa-solid fa-check check-label" style=""></i></label>
                                    <input type="date" class="form-control" id="birthdate" name="birthdate" required
                                        placeholder="" value="{{$details->birthdate}}" />
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="sex" class="form-label">Sex: <i id="check-sex"
                                            class="fa-solid fa-check check-label" style=""></i></label>
                                    <select class="form-select" name="sex" id="sex" aria-label="Default select example"
                                        required>
                                        <option selected value="">Select sex</option>
                                        <option value="Male" {{$details->sex == 'Male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="Female" {{$details->sex == 'Female' ? 'selected' : '' }}>Female
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Phone number <i id="check-phone_number"
                                            class="fa-solid fa-check check-label" style=""></i></label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number"
                                        required placeholder="+639123456789" value="{{$details->phone_number}}" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address <i id="check-address"
                                            class="fa-solid fa-check check-label" style=""></i></label>
                                    <input class="form-control" required id="address" name="address"
                                        value="{{$details->address}}" placeholder="Enter address..." />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="col-12">
                                    <div class="mb-3">
                                        @if ($details->valid_id !== '' || $details->valid_id !== null)
                                        <label class="form-label">Initial Image:</label>
                                        <div class="col-10 mx-auto">
                                            <img class="img-fluid" style="border-radius: 10px"
                                                src="/{{ $details->valid_id }}" alt="" srcset="">
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <label for="image" class="form-label">Valid ID <i id="check-valid_id"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <div class="input-group">

                                    <input type="file" name="valid_id" class="form-control" id="valid_id">
                                    <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                </div>
                                <label id="image-error" class="error" for="valid_id" style="display: none"></label>
                            </div>
                            <div class="col-lg-6">

                                <div class="col-12">
                                    <div class="mb-3">
                                        @if ($details->license !== '' || $details->license !== null)
                                        <label class="form-label">Initial Image:</label>
                                        <div class="col-10 mx-auto">
                                            <img class="img-fluid" style="border-radius: 10px"
                                                src="/{{ $details->license }}" alt="" srcset="">
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <label for="image" class="form-label">Driver's License <i id="check-license"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <div class="input-group">



                                    <input type="file" name="license" class="form-control" id="license">
                                    <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                </div>
                                <label id="image-error" class="error" for="license" style="display: none"></label>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top:20px;padding:20px 0;">
                        <div class="row justify-content-end">
                            <div class="col-lg-3">
                                <input type="submit" class="btn-form" value="Update Instructor">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>



<script>
$(document).ready(function() {
    $.validator.addMethod("mobileNumber", function(value, element) {
        return value.trim().match(/^(09|\+639)\d{9}$/);
    }, jQuery.validator.format("Please enter a valid mobile number."));
    $.validator.addMethod("textOnly", function(value, element) {
        return value.trim().match(/^[A-Za-z ]+$/);
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
            },
            lastname: {
                required: true,
                textOnly: true,
            },
            birthdate: {
                required: true,
                validateAge: true
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
        },
        messages: {
            firstname: {
                required: "Firstname is required",
                textOnly: "Firstname is invalid"
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
            },
            address: {
                required: "Address is required"
            }
        },
        submitHandler: function(form) {
            $.ajax({
                type: "POST",
                url: "{{ route('update.instructor')}}",
                contentType: false,
                processData: false,
                data: new FormData(form),
                success: function(response) {
                    if (response.code == 200) {
                        swal({
                            icon: "success",
                            title: 'Instructor Successfully Updated',
                            text: " ",
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(function() {
                            window.location.href =
                                "{{ route('index.instructor') }}";
                        });
                    }

                },
                error: function(xhr, status, error) {
                    console.log("AJAX Error: " + error);
                }
            });
        }
    });
});
</script>

@include(SchoolFileHelper::$footer)