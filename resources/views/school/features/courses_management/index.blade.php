@include(SchoolFileHelper::$header, ['title' => 'Courses Management'])

<div class="container-fluid" style="padding: 20px;margin-top:60px">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-sm-2"> <label for="">Status</label>
                    <select id="status" class='form-select mb-3' name="status" required>
                        <option value="0" selected>All</option>
                        <option value="1">Available</option>
                        <option value="2">Not Available</option>
                    </select>
                </div>
                <div class="col-sm-3" id="changeradio">
                </div>
                <div class="col-sm-3"><label for="">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control mb-3" required>
                </div>
                <div class="col-sm-3"> <label for="">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control mb-3" required>
                </div>
                <div class="col-1">
                    <center><br><button type="submit" id="filterbutton" class="btn btn-primary">Filter</button></center>
                </div>
            </div>
            <div id="filterresult">
                <div class="w-100 d-flex justify-content-between table-header-btn">
                    <div class="d-flex" style="gap:15px">
                        <a class="btn-outline-light" href="{{route('courses.export.pdf')}}"><i class="fa-solid fa-file-export"></i>Export
                            PDF</a>
                    </div>
                    <a href="{{ route('create.course') }}">
                        <button class="btn-add-management"><i class="fa-solid fa-plus"></i> Add new
                            Course</button>
                    </a>

                </div>
                <table id="table" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>

                            <th width="120">Status</th>
                            <th width="200">Date Created</th>
                            <th>Date Updated</th>
                            <th width="50">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-lg" id="courseFormModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" id="modal_title">Add New Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="courseForm">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Course name: <i id="check-name" class="fa-solid fa-check check-label" style=""></i></label>
                                            <div>
                                                <input type="text" class="form-control" name="name" id="name" id="name" placeholder="Enter course name..." required />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="duration" class="form-label">Duration: (hours)<i id="check-duration" class="fa-solid fa-check check-label" style=""></i></label>
                                            <input type="number" class="form-control" id="duration" name="duration" placeholder="Enter duration..." required />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Price: <i id="check-price" class="fa-solid fa-check check-label" style=""></i></label>
                                            <div>
                                                <input type="text" class="form-control" name="price" id="price" id="price" placeholder="Enter price..." required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status: <i id="check-status" class="fa-solid fa-check check-label" style=""></i></label>
                                            <select class="form-select" name="status" id="status" aria-label="Default select example" required>

                                                <option value="1">Available</option>
                                                <option value="0">Not available</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Course Description: <i id="check-description" class="fa-solid fa-check check-label" style=""></i></label>
                                            <div>
                                                <textarea name="description" class="form-control" id="description"></textarea>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Course thumbnail: <i id="check-image" class="fa-solid fa-check check-label" style=""></i></label>
                                            <div>
                                                <input type="file" class="form-control" name="image" id="image" id="image" required />
                                            </div>
                                        </div>
                                    </div>
                                    @foreach ($progress as $data)
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    {{ $data->title }}
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div style="padding:20px 0;">
                                    <div class="row justify-content-end">
                                        <div class="col-lg-3">
                                            <input type="submit" class="btn-form" id="modal_submit" value="Add Course">
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
<script>
    let operation;
    let data;
    let id;
    let table;
    displayCourses();
    $('#modal_btn').click(function(e) {
        operation = "add";
        $('#courseFormModal').modal('show');
    });

    let formValidation = $("#courseForm").validate({
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
            duration: {
                required: true,
            },
            price: {
                required: true,
            },
            status: {
                required: true,
            },
            image: {
                required: true,
            },
            description: {
                required: true,
            },

        },
        messages: {
            name: {
                required: "Course name is required",
            },
            duration: {
                required: "Duration is required",
            },
            price: {
                required: "Price is required",
            },
            status: {
                required: "Status is required",
            },
            description: {
                required: "Description is required",
            },
            image: {
                required: "Thumbnail is required",
            },
        },
        submitHandler: function(form) {
            $.ajax({
                type: "POST",
                url: "{{ route('create.course') }}",
                processData: false,
                contentType: false,
                data: new FormData(form),
                success: function(response) {
                    console.log(response);
                    if (response.code == 200) {
                        if (operation == "add") {
                            swal({
                                icon: "success",
                                title: 'Added Successfully',
                                text: " ",
                                timer: 2000,
                                button: false,
                            })
                        } else {
                            data.remove().draw(false);
                            swal({
                                icon: "success",
                                title: 'Updated Successfully',
                                text: " ",
                                timer: 2000,
                                button: false,
                            })
                        }

                        table.row.add(response.course).draw(false);
                        resetForm();
                        $('#courseFormModal').modal('hide');
                        return;
                    }
                    swal({
                        icon: "error",
                        title: 'Something went wrong',
                        text: "Try to repeat the process",
                        timer: 2000,
                        button: false,
                    })
                }
            });

        }
    });

    // $(document).on('click', '.update', function() {
    //     resetForm();
    //     operation = "edit";
    //     data = $('#table').DataTable().row($(this).parents('tr'));
    //     const tempData = data.data();
    //     id = tempData.id;
    //     $('#modal_title').html('Update a Course');
    //     $('#courseFormModal').modal('show');
    //     $('#modal_submit').val('Update Course');

    //     $('#name').val(tempData.name);
    //     $('#duration').val(tempData.duration);
    //     $('#price').val(tempData.price);
    //     $('#description').val(tempData.description);
    //     $('#status').val(tempData.status);
    // });

    function displayCourses() {
        $.ajax({
            type: "POST",
            url: "{{ route('retrieve.course') }}",
            data: $(this).serialize(),
            success: function(response) {

                table = $('#table').DataTable({
             
                    order: [3, 'desc'],
                    data: JSON.parse(response),
                    columns: [{
                            data: 'name',
                        },

                        {
                            data: null,
                            render: function(data, type, row) {
                                return data['status'] == 1 ?
                                    '<span class="available">&#8226 Available</span>' :
                                    '<span class="not-available">&#8226 Not available</span>';
                            }
                        },
                        {
                            data: 'date_created',
                            render: function(data, type, row) {
                                var birthdate = moment(data).format(
                                    'MMMM D, YYYY - hh:mm A');
                                return birthdate;
                            }

                        },
                        {
                            data: 'date_updated',
                            visible: false,
                        },

                        {
                            data: null,
                            render: function(data, type, row) {
                                return `<div class="dropdown">
                                            <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            </i>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="/school/courses/${data['id']}/view">View course</a></li>
                                                <li><a class="dropdown-item update" href="/school/courses/${data['id']}/updateView">Update</a></li>
                                                <li><a class="dropdown-item delete" href="#">Delete</a></li>
                                            </ul>
                                        </div>`;
                            }
                        },
                    ],
                    // dom: 'Bfrtip',
                    // buttons: [{
                    //         extend: 'copy',
                    //         exportOptions: {
                    //             columns: ':visible:not(:last-child)'
                    //         },
                    //         title: 'List of Courses',
                    //     },
                    //     {
                    //         extend: 'csv',
                    //         exportOptions: {
                    //             columns: ':visible:not(:last-child)'
                    //         },
                    //         title: 'List of Courses'
                    //     },
                    //     {
                    //         extend: 'excel',
                    //         exportOptions: {
                    //             columns: ':visible:not(:last-child)'
                    //         },
                    //         title: 'List of Courses'
                    //     },
                    //     {
                    //         extend: 'pdf',
                    //         exportOptions: {
                    //             columns: ':visible:not(:last-child)' // Exclude hidden columns
                    //         },
                    //         title: 'List of Courses',
                    //         customize: function(doc) {
                    //             // Adjust the width of the table in the PDF
                    //             doc.content[1].table.widths = Array(doc.content[1].table.body[0]
                    //                 .length + 1).join('*').split('');
                    //         }
                    //     },
                    //     {
                    //         extend: 'print',

                    //         exportOptions: {
                    //             columns: ':visible:not(:last-child)' // Exclude hidden columns
                    //         },
                    //         title: 'List of Courses'
                    //     }
                    // ],


                });
            }
        });
    }

    function resetForm() {
        $('.check-label').css('display', 'none');
        $('.error').css('display', 'none');
        $('#courseForm').trigger("reset");
    }



    $(document).on('click', '.delete', function() {
        data = $('#table').DataTable().row($(this).parents('tr'));
        const tempData = data.data();
        id = tempData.id;

        swal({
            title: "Delete Course?",
            text: "Are you sure you want to delete course? ",
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
                    url: "{{ route('delete.course') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        course_id: id,
                    },
                    success: function(response) {
                        if (response.code == 200) {
                            swal({
                                icon: "success",
                                title: 'Course Successfully Deleted',
                                text: " ",
                                timer: 2000,
                                showConfirmButton: false,
                            }).then(function() {
                                window.location.href =
                                    "{{ route('index.courses') }}";
                            });
                        } else {
                            swal({
                                icon: "error",
                                title: 'The deletion was unsuccessful. The course is already in use',
                                text: " ",
                                timer: 2000,
                                showConfirmButton: false,
                            });
                        }

                    }
                });
            } else {

            }
        });

    });

    $('#filterbutton').click(function() {
        var status = $('#status').val();
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();


        var startDateObj = new Date(start_date);
        var endDateObj = new Date(end_date);

        ///revision
        var currentDate = new Date();
        currentDate.setHours(0, 0, 0, 0);
        endDateObj.setHours(0, 0, 0, 0);

        if (!start_date && !end_date) {
            swal({
                icon: "error",
                title: 'Both Start Date and End Date are Empty',
                text: " ",

            });
        } else if (!start_date || !end_date) {
            swal({
                icon: "error",
                title: 'Invalid Date Range There is an Empty Date',
                text: " ",

            });
        } else if ((startDateObj > endDateObj) || (endDateObj < startDateObj)) {
            swal({
                icon: "error",
                title: 'Invalid Date Range',
                text: " ",
            });
        } else if (endDateObj > currentDate) {
            ///revision
            swal({
                icon: "error",
                title: 'End Date should be equal to or less than the current date',
                text: " ",
            });
        } else {
            $.ajax({
                url: '{{route("school.filter.courses")}}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status,
                    start_date,
                    end_date,
                },
                success: function(response) {
                    $('#filterresult').html(response);

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log("Error Thrown: " + errorThrown);
                    console.log("Text Status: " + textStatus);
                    console.log("XMLHttpRequest: " + XMLHttpRequest);
                    console.warn(XMLHttpRequest.responseText)
                }
            });
        }
    });
</script>
@include(SchoolFileHelper::$footer)