@include('admin.includes.header', ['title' => 'Update admin'])
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
            <form id="admin_form" enctype="multipart/form-data">
                @csrf
                <div class="col-12">
                    <h6 style="margin-bottom: 15px">Personal Information</h6>
                </div>
                <div class="card" style="padding: 20px">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <input type="hidden" name="admin_id" id="admin_id" value="{{$admin->admin_id}}">
                                <label for="firstname" class="form-label">Firstname: <i id="check-firstname"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="text" value="{{ $admin->firstname }}" class="form-control" id="firstname"
                                    name="firstname" placeholder="Enter firstname..." required />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="middlename" class="form-label">Middlename: <i id="check-middlename"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="text" value="{{ $admin->middlename }}" class="form-control" id="middlename"
                                    name="middlename" placeholder="Enter middlename..." required />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="lastname" class="form-label">Lastname: <i id="check-lastname"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="text" value="{{ $admin->lastname }}" class="form-control" id="lastname"
                                    name="lastname" placeholder="Enter lastname..." required />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="sex" class="form-label">Sex: <i id="check-sex"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <select class="form-select" name="sex" id="sex" aria-label="Default select example"
                                    required>
                                    <option selected value="" style="display:none">Select sex</option>
                                    <option value="Male" {{ $admin->sex == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $admin->sex == 'Female' ? 'selected' : '' }}>Female
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="birthdate" class="form-label">Birthdate: <i id="check-birthdate"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="date" class="form-control" id="birthdate" value="{{ $admin->birthdate }}"
                                    name="birthdate" placeholder="Select birthdate..." required />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone number <i id="check-phone_number"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="text" class="form-control" id="phone_number"
                                    value="{{ $admin->phone_number }}" name="phone_number" required
                                    placeholder="+639123456789" />
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label for="address" class="form-label">Address <i id="check-address"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <input class="form-control" required id="address" name="address"
                                    placeholder="Enter address..." value="{{ $admin->address }}" />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="images" class="form-label">Profile picture: <i id="check-images"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="file" class="form-control" id="images" name="images" required />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end" style="margin-top:20px">
                    <button class="btn-add">Update Admin</button>
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
        },
        submitHandler: function(form) {
            $.ajax({
                type: "POST",
                url: "{{ route('save.update.admin')}}",
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
                error: function(xhr, status, error) {
                    console.log("AJAX Error: " + error);
                }
            });
        }
    });
});
</script>
@include('admin.includes.footer')