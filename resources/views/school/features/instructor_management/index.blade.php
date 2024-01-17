@include(SchoolFileHelper::$header, ['title' => 'Instructor Management'])

<div class="container-fluid" style="padding: 20px;margin-top:60px">
    <div class="row">
        <div class="col-12">
            @if (session('errors'))
                <div class="alert alert-danger">

                    @foreach (session('errors') as $error)
                        <h6 style="margin-bottom: 5px;color:red">{{ $error }}</h6>
                    @endforeach

                </div>
            @endif
            <div class="w-100 d-flex align-items-center justify-content-between table-header-btn">
                <div class="d-flex" style="gap:15px">
                    <a class="btn-outline-light" href="{{ route('instructor.export.pdf') }}"><i
                            class="fa-solid fa-file-export"></i>Export
                        PDF</a>
                    <button data-bs-toggle="modal" data-bs-target="#importForm" class="btn-outline-light"><i
                            class="fa-solid fa-file-export"></i>Import Excel</button>
                </div>
                <a href="{{ route('create.instructor') }}">
                    <button id="modal_btn" class="btn-add-management">
                        <i class="fa-solid fa-plus"></i> Add new instructor
                    </button>
                </a>
                {{-- <a href="http://">
                    <button class="btn-add-management"><i class="fa-solid fa-plus"></i> Add new
                        instructor</button>
                </a> --}}
            </div>
            <table id="table" class="table" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Sex</th>
                        <th>Phone Number</th>
                        <th>Birthdate</th>
                        <th style="width: 60px">Status</th>
                        <th>Date updated</th>
                        <th style="width: 60px">Action</th>

                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade modal-lg" id="firstFormModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog  modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" id="exampleModalLabel">Add New Instructor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="firstForm" id="instructor_form">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="col-12" style="margin:10px 0 30px 0">
                                    <h6>Profile Picture</h6>
                                </div>
                                <img class="img-fluid" style="border-radius: 10px"
                                    src="https://i.pinimg.com/originals/f1/0f/f7/f10ff70a7155e5ab666bcdd1b45b726d.jpg"
                                    alt="" srcset="">

                                <div class="mb-3" style="margin-top: 30px">
                                    <input type="file" class="form-control" name="image" />
                                </div>
                            </div>
                            <div class="col-lg-10">
                                <div class="col-12" style="margin:10px 0 30px 0">
                                    <h6>Personal Information</h6>
                                </div>
                                <div
                                    style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;padding:20px;border-radius:20px">
                                    <div class="row">

                                        <div class="col-lg-4">

                                            <div class="mb-3">
                                                <label for="firstname" class="form-label">Firstname: <i
                                                        id="check-firstname" class="fa-solid fa-check check-label"
                                                        style=""></i></label>
                                                <div>
                                                    <input type="text" class="form-control" name="firstname"
                                                        id="firstname" id="firstname" placeholder="Enter firstname..."
                                                        required />
                                                </div>


                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="middlename" class="form-label">Middlename:(optional) <i
                                                        id="check-middlename" class="fa-solid fa-check check-label"
                                                        style=""></i></label>
                                                <input type="text" class="form-control" id="middlename"
                                                    name="middlename" placeholder="Enter middlename..." required />
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="lastname" class="form-label">Lastname: <i
                                                        id="check-lastname" class="fa-solid fa-check check-label"
                                                        style=""></i></label>
                                                <input type="text" class="form-control" id="lastname"
                                                    name="lastname" required placeholder="Enter lastname..." />
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="birthdate" class="form-label">Birthdate: <i
                                                        id="check-birthdate" class="fa-solid fa-check check-label"
                                                        style=""></i></label>
                                                <input type="date" class="form-control" id="birthdate"
                                                    name="birthdate" required placeholder="" />
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="sex" class="form-label">Sex: <i id="check-sex"
                                                        class="fa-solid fa-check check-label"
                                                        style=""></i></label>
                                                <select class="form-select" name="sex" id="sex"
                                                    aria-label="Default select example" required>
                                                    <option selected value="">Select sex</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="phone_number" class="form-label">Phone number <i
                                                        id="check-phone_number" class="fa-solid fa-check check-label"
                                                        style=""></i></label>
                                                <input type="text" class="form-control" id="phone_number"
                                                    name="phone_number" required placeholder="+639123456789" />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="address" class="form-label">Address <i
                                                        id="check-address" class="fa-solid fa-check check-label"
                                                        style=""></i></label>
                                                <input class="form-control" required id="address" name="address"
                                                    placeholder="Enter address..." />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12" style="margin: 30px 0">
                                    <h6>Account Information</h6>
                                </div>
                                <div
                                    style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;padding:20px;border-radius:20px">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Username: <i
                                                        id="check-username" class="fa-solid fa-check check-label"
                                                        style=""></i></label>
                                                <input type="text" class="form-control" id="username"
                                                    name="username" required placeholder="Enter username..." />
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email: <i id="check-email"
                                                        class="fa-solid fa-check check-label"
                                                        style=""></i></label>
                                                <input type="text" class="form-control" id="email"
                                                    name="email" placeholder="Enter email..." />

                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password: <i
                                                        id="check-password" class="fa-solid fa-check check-label"
                                                        style=""></i></label>
                                                <input type="password" class="form-control" id="password"
                                                    name="password" required placeholder="Enter password..." />

                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="password_confirmation" class="form-label">Confirm
                                                    Password: <i id="check-password_confirmation"
                                                        class="fa-solid fa-check check-label"
                                                        style=""></i></label>
                                                <input type="password" class="form-control"
                                                    id="password_confirmation" name="password_confirmation" required
                                                    placeholder="Enter password..." />

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-top:20px;padding:20px 0;">
                                    <div class="row justify-content-end">
                                        <div class="col-lg-3">
                                            <input type="submit" class="btn-form" value="Create Instructor">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="importForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Import Instructor</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('import.instructor') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Excel file: </label>
                        <input class="form-control" type="file" id="formFile" name="file">
                    </div>
                    <div style="margin-top:20px">
                        <div class="row justify-content-end">
                            <div class="col-lg-12">
                                <input type="submit" class="btn-form" value="Import">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@if (session('message'))
    <script>
        Toastify({
            text: "{{ session('message') }}",
            duration: 2000,

            gravity: "top", // `top` or `bottom`
            position: "center", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: "forestgreen",
            },
            onClick: function() {} // Callback after click
        }).showToast();
    </script>
@endif
<script>
    let table;
    displayInstructors();
    $(document).ready(function() {
        $.validator.addMethod("mobileNumber", function(value, element) {
            return value.trim().match(/^(09|\+639)\d{9}$/);
        }, jQuery.validator.format("Please enter a valid mobile number."));
        $.validator.addMethod("textOnly", function(value, element) {
            return value.trim().match(/^[A-Za-z ]+$/);
        });

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
                    remote: "Phone number is already in use"
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
                    url: "{{ route('store.instructor') }}",
                    contentType: false,
                    processData: false,
                    data: new FormData(form),
                    success: function(response) {
                        if (response.code == 200) {
                            table.row.add(response.instructor).draw(false);
                            resetForm();
                            $('#firstFormModal').modal('hide');
                        }
                        console.log(response);
                    },

                });
            }
        });
    });

    function displayInstructors() {
        $.ajax({
            type: "POST",
            url: "{{ route('retrieve.instructor') }}",
            data: $(this).serialize(),
            success: function(response) {
                console.log(response);
                table = $('#table').DataTable({

                    order: [5, 'desc'],
                    data: JSON.parse(response),
                    columns: [{
                            data: function(data, type, row) {

                                return `

                                <div class="d-flex align-items-center" style="gap: 10px;padding:5px 0">
                    <img src="/` + data.profile_image + `" class="rounded-circle"
                        style="width: 40px;height:40px;object-fit: cover;" alt="Avatar" />
                        <div>
                            <h6>` + data.firstname + " " + data.middlename +
                                    " " + data
                                    .lastname + `</h6>
                            <p style="font-size:14px" class="email">` + data.email + `</p>
                            </div>
                </div>                             
                                `;
                            }
                        },
                        {
                            data: 'sex'
                        },
                        {
                            data: 'phone_number'
                        },
                        {
                            data: 'birthdate',
                            render: function(data, type, row) {
                                var birthdate = moment(data).format(
                                    'MMMM D, YYYY');
                                return birthdate;
                            }
                        },
                        {

                            data: 'status',
                            render: function(data, type, row) {
                                if (data == 3) {
                                    return 'Staff';
                                }
                                if (data == 1) {
                                    return 'Active';
                                }
                                return "";
                            }
                        },
                        {
                            data: 'updated_at',
                            visible: false,

                        },
                        {
                            data: null,

                        },
                    ],
                    columnDefs: [{
                        data: null,
                        targets: -1,
                        render: function(data) {
                            if (data.status == 3) {
                                return "";
                            }
                            var updateURL =
                                "{{ route('update.instructor.page', ':id') }}"
                                .replace(':id', data.user_id);
                            var moreDetailsURL =
                                "{{ route('more.details.instructor', ':id') }}"
                                .replace(
                                    ':id', data.user_id);

                            return `<div class="dropdown">
            <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown" aria-expanded="false"></i>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="${moreDetailsURL}">More Details</a></li>
                <li><a class="dropdown-item update" href="${updateURL}">Update</a></li>
                <li><a class="dropdown-item delete" href="#">Delete</a></li>
                <li><a class="dropdown-item update" onclick="r= confirm('Are you sure you want to make as staff ? it cannot be undo.');if(r==true){location.href='/school/instructors/${data.id}/promote';}">Make as staff</a></li>
            </ul>
        </div>`;
                        }
                    }],
                    // dom: 'Bfrtip',
                    // buttons: [{
                    //         extend: 'copy',
                    //         exportOptions: {
                    //             columns: ':visible:not(:last-child)'
                    //         },
                    //         title: 'List of Instructors'
                    //     },
                    //     {
                    //         extend: 'csv',
                    //         exportOptions: {
                    //             columns: ':visible:not(:last-child)'
                    //         },
                    //         title: 'List of Instructors'
                    //     },
                    //     {
                    //         extend: 'excel',
                    //         exportOptions: {
                    //             columns: ':visible:not(:last-child)'
                    //         },
                    //         title: 'List of Instructors'
                    //     },
                    //     {
                    //         extend: 'pdf',
                    //         exportOptions: {
                    //             columns: ':visible:not(:last-child)' // Exclude hidden columns
                    //         },
                    //         title: 'List of Instructors',

                    //     },
                    //     {
                    //         extend: 'print',

                    //         exportOptions: {
                    //             columns: ':visible:not(:last-child)' // Exclude hidden columns
                    //         },
                    //         title: 'List of Instructors'
                    //     }
                    // ],



                });
            }
        });
    }

    // chrissha nagcomment
    // $(document).on('click', '.update', function() {
    //     const rowData = $('#table').DataTable().row($(this).parents('tr')).data();

    // });


    // $(document).ready(function() {
    //     $('#firstname').keyup(function(e) {
    //         validateName($(this), $('#firstname-error'));
    //     });
    //     $('#middlename').keyup(function(e) {
    //         validateName($(this), $('#middlename-error'));
    //     });
    //     $('#lastname').keyup(function(e) {
    //         validateName($(this), $('#lastname-error'));
    //     });

    //     function validateName($input, $error) {
    //         if ($input.val().trim().match(/^[A-Za-z ]+$/)) {
    //             $error.css('display', 'none');
    //         } else {
    //             $error.css('display', 'block');
    //         }
    //     }

    // });

    function resetForm() {
        $('.check-label').css('display', 'none');
        $('.error').css('display', 'none');
        $('#instructor_form').trigger("reset");
    }




    $(document).on('click', '.delete', function() {
        data = $('#table').DataTable().row($(this).parents('tr'));
        const tempData = data.data();
        id = tempData.user_id

        swal({
            title: "Delete Instructor?",
            text: "Are you sure you want to delete Instructor? ",
            icon: "warning",
            buttons: {
                cancel: "Cancel",
                yes: {
                    text: "Yes",
                    value: "yes",
                },

            },
        }).then((value) => {
            if (value === "yes") {
                $.ajax({
                    type: "POST",
                    url: "{{ route('delete.instructor') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        instructor_id: id,
                    },
                    success: function(response) {
                        if (response.code == 200) {
                            swal({
                                icon: "success",
                                title: 'Instructor Successfully Deleted',
                                text: " ",
                                timer: 2000,
                                showConfirmButton: false,
                            }).then(function() {
                                window.location.href =
                                    "{{ route('index.instructor') }}";
                            });
                        } else {
                            swal({
                                icon: "error",
                                title: `${response.message}`,
                                text: " ",
                                timer: 2000,

                            })
                        }
                    }
                });
            } else {

            }
        });

    });
</script>
@include(SchoolFileHelper::$footer)
