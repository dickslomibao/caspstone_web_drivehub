@include(SchoolFileHelper::$header, ['title' => 'Update staff information'])
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
<?php

$abilities = explode(',', $staff->role);
?>
<div class="container-fluid" style="padding: 20px;margin-top:60px">

    <div class="row">
        <div class="col-12">
            <form action="{{ route('save.staff', [
                'staff_id' => $staff->staff_id,
            ]) }}" method="POST" id="staff_form" enctype="multipart/form-data">
                @csrf
                <div class="col-12">
                    <h6 style="margin-bottom: 15px">Personal Information</h6>
                </div>
                <div class="card" style="padding: 20px">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="firstname" class="form-label">Firstname: <i id="check-firstname" class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="text" value="{{ $staff->firstname }}" class="form-control" id="firstname" name="firstname" placeholder="Enter firstname..." required />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="middlename" class="form-label">Middlename: <i id="check-middlename" class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="text" value="{{ $staff->middlename }}" class="form-control" id="middlename" name="middlename" placeholder="Enter middlename..." required />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="lastname" class="form-label">Lastname: <i id="check-lastname" class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="text" value="{{ $staff->lastname }}" class="form-control" id="lastname" name="lastname" placeholder="Enter lastname..." required />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="sex" class="form-label">Sex: <i id="check-sex" class="fa-solid fa-check check-label" style=""></i></label>
                                <select class="form-select" name="sex" id="sex" aria-label="Default select example" required>
                                    <option selected value="" style="display:none">Select sex</option>
                                    <option value="Male" {{ $staff->sex == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $staff->sex == 'Female' ? 'selected' : '' }}>Female
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="birthdate" class="form-label">Birthdate: <i id="check-birthdate" class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="date" class="form-control" id="birthdate" value="{{ $staff->birthdate }}" name="birthdate" placeholder="Select birthdate..." required />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone number <i id="check-phone_number" class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="text" class="form-control" id="phone_number" value="{{ $staff->phone_number }}" name="phone_number" required placeholder="+639123456789" />
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label for="address" class="form-label">Address <i id="check-address" class="fa-solid fa-check check-label" style=""></i></label>
                                <input class="form-control" required id="address" name="address" placeholder="Enter address..." value="{{ $staff->address }}" />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="images" class="form-label">Profile picture: <i id="check-images" class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="file" class="form-control" id="images" name="images" required />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="col-12">
                                <div class="mb-3">
                                    @if ($staff->valid_id !== '' || $staff->valid_id !== null)
                                    <label class="form-label">Initial Image:</label>
                                    <div class="col-10 mx-auto">
                                        <img class="img-fluid" style="border-radius: 10px" src="/{{ $staff->valid_id }}" alt="" srcset="">
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <label for="image" class="form-label">Valid ID <i id="check-valid_id" class="fa-solid fa-check check-label" style=""></i></label>
                            <div class="input-group">

                                <input type="file" name="valid_id" class="form-control" id="valid_id">
                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                            </div>
                            <label id="image-error" class="error" for="valid_id" style="display: none"></label>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <h6 style="margin: 15px 0">Staff Access Control</h6>
                </div>
                <div class="card" style="padding: 20px">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="role[]" value="1" id="flexCheckDefault" {{ in_array(1, $abilities) ? 'checked' : '' }}>
                                <label class="form-check-label" for="1">
                                    Instructor management
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="role[]" value="2" id="flexCheckDefault" {{ in_array(2, $abilities) ? 'checked' : '' }}>
                                <label class="form-check-label" for="1">
                                    Vechile management
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="role[]" value="3" id="flexCheckDefault" {{ in_array(3, $abilities) ? 'checked' : '' }}>
                                <label class="form-check-label" for="1">
                                    Course management
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="role[]" value="4" id="flexCheckDefault" {{ in_array(4, $abilities) ? 'checked' : '' }}>
                                <label class="form-check-label" for="1">
                                    Promo management
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="role[]" value="5" id="flexCheckDefault" {{ in_array(5, $abilities) ? 'checked' : '' }}>
                                <label class="form-check-label" for="1">
                                    Staff management
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="role[]" value="6" id="flexCheckDefault" {{ in_array(6, $abilities) ? 'checked' : '' }}>
                                <label class="form-check-label" for="1">
                                    Progress management
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="role[]" value="7" id="flexCheckDefault" {{ in_array(7, $abilities) ? 'checked' : '' }}>
                                <label class="form-check-label" for="1">
                                    Process operation
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="role[]" value="8" id="flexCheckDefault" {{ in_array(8, $abilities) ? 'checked' : '' }}>
                                <label class="form-check-label" for="1">
                                    Messages
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="role[]" value="9" id="flexCheckDefault" {{ in_array(9, $abilities) ? 'checked' : '' }}>
                                <label class="form-check-label" for="1">
                                    Question Managment
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end" style="margin-top:20px">
                    <button class="btn-add">Updates staff</button>
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

        $("#staff_form").validate({
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
                    validateAge: true,
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
                images: {
                    required: false
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
                },
            },
            submitHandler: function(form) {
                form.submit();
                // $.ajax({
                //     type: "POST",
                //     url: "{{ route('store.staff') }}",
                //     contentType: false,
                //     processData: false,
                //     data: new FormData(form),
                //     success: function(response) {
                //         // if (response.code == 200) {

                //         // }
                //         console.log(response);
                //     }
                // });
            }
        });
    });
</script>
@include(SchoolFileHelper::$footer)