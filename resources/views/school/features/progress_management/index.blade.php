@include(SchoolFileHelper::$header, ['title' => 'Progress Management'])

<div class="container-fluid" style="padding: 20px;margin-top:60px">
    <div class="row">
        <div class="col-12">
            <div class="w-100 d-flex justify-content-between table-header-btn">
                <div class="d-flex" style="gap:15px">
                    <a class="btn-outline-light" href="{{ route('progress.export.pdf') }}"><i
                            class="fa-solid fa-file-export"></i>Export
                        PDF</a>
                    <!--  <button class="btn-outline-light"><i class="fa-solid fa-file-export"></i>Import CSV</button> -->
                </div>
                <button class="btn-add-management" id="modal_btn_add_progress"><i class="fa-solid fa-plus"></i> Add new
                    Progress</button>
            </div>
            <table id="table" class="table" style="width:100%">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Total Sub-progress</th>
                        <th>Date Created</th>
                        <th>Date update</th>
                        <th width="50">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="progress_form_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" id="modal_title">Add New Progress</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="progress_form">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Title: <i id="check-title"
                                                    class="fa-solid fa-check check-label" style=""></i></label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                required placeholder="Enter progress title..." />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description: <i
                                                    id="check-description" class="fa-solid fa-check check-label"
                                                    style=""></i></label>
                                            <textarea class="form-control" row="20" id="description" name="description" required
                                                placeholder="Enter progress description..."></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div style="padding:0 0 20px 0;">
                                    <div class="row justify-content-end">
                                        <div class="col-12">
                                            <input type="submit" class="btn-form" id="modal_add_submit"
                                                value="Add Progress">
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


<div class="modal fade" id="view_details_progress_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" id="modal_title_view">View Progress Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-center justify-content-between">
                    <h6>Sub progress:</h6>
                    <button class="btn-add-management" id="modal_btn_add_sub_progress"
                        data-bs-target="#sub_progress_form_modal" data-bs-toggle="modal">
                        <i class="fa-solid fa-plus"></i>
                        Add new Sub-Progress
                    </button>
                </div>
                <br>
                <table id="sub_progress_table" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Date created</th>
                            <th>Date Updated</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="sub_progress_form_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" id="modal_title">Add New Sub-Progress</h5>
                <button type="button" class="btn-close" data-bs-target="#view_details_progress_modal"
                    data-bs-toggle="modal"></button>
            </div>
            <div class="modal-body">
                <form id="sub_progress_form">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Title: <i id="check-title"
                                                    class="fa-solid fa-check check-label" style=""></i></label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                required placeholder="Enter progress title..." />
                                        </div>
                                    </div>
                                </div>
                                <div style="padding:0px 0 20px  0;">
                                    <div class="row justify-content-end">
                                        <div class="col-12">
                                            <input type="submit" class="btn-form" id="modal_submit" value="Add">
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






<div class="modal fade" id="sub_progress_update_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" id="modal_title">Update Sub-Progress</h5>
            </div>
            <div class="modal-body">
                <form id="sub_progress_update_form">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Title: <i id="check-subtitle"
                                                    class="fa-solid fa-check check-label" style=""></i></label>
                                            <input type="text" class="form-control" id="subtitle"
                                                name="subtitle" required placeholder="Enter progress title..." />

                                            <input type="hidden" class="form-control" id="subprog_id"
                                                name="subprog_id" required />

                                        </div>
                                    </div>
                                </div>
                                <div style="padding:0px 0 20px  0;">
                                    <div class="row justify-content-end">
                                        <div class="col-12">
                                            <input type="submit" class="btn-form" id="modal_submit" value="Update">
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
    let table;
    let operation = "add";
    let subProgressTable;
    let selected_progress;

    displayProgress();
    let formValidation = $("#progress_form").validate({
        highlight: function(element, errorClass, validClass) {
            $("#check-" + element.name).css('display', 'none');
        },
        unhighlight: function(element, errorClass, validClass) {
            $("#check-" + element.name).css('display', 'inline-block');
        },
        rules: {

            title: {
                required: true,
            },
            description: {
                required: true,
            },
        },
        messages: {

            title: {
                required: 'Title is required',
            },
            description: {
                required: 'Description is required',
            },

        },
        submitHandler: function(form) {
            let url = operation == "add" ? "{{ route('progress.create') }}" : "/school/progress/" +
                selected_progress.data().id + "/update"
            $.ajax({
                type: "POST",
                url: url,
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
                            selected_progress.remove().draw(false);
                            swal({
                                icon: "success",
                                title: 'Updated Successfully',
                                text: " ",
                                timer: 2000,
                                button: false,
                            })
                        }
                        table.row.add(response.progress).draw(false);
                        resetForm();
                        $('#progress_form_modal').modal('hide');
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




    let subProgressForm = $("#sub_progress_form").validate({
        highlight: function(element, errorClass, validClass) {
            $("#check-" + element.id).css('display', 'none');
        },
        unhighlight: function(element, errorClass, validClass) {
            $("#check-" + element.id).css('display', 'inline-block');
        },
        rules: {
            title: {
                required: true,
            },
        },
        messages: {

            title: {
                required: 'Title is required',
            },

        },
        submitHandler: function(form) {
            $.ajax({
                type: "POST",
                url: "/school/progress/" + selected_progress.data().id + "/subprogress/create",
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
                            subProgressTable.row.add(response.progress).draw(false);
                            $('#sub_progress_form_modal').modal('hide');
                            $('#view_details_progress_modal').modal('show');
                        }
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


    let subProgressUpdateForm = $("#sub_progress_update_form").validate({
        highlight: function(element, errorClass, validClass) {
            $("#check-" + element.id).css('display', 'none');
        },
        unhighlight: function(element, errorClass, validClass) {
            $("#check-" + element.id).css('display', 'inline-block');
        },
        rules: {
            subtitle: {
                required: true,
            },
        },
        messages: {

            subtitle: {
                required: 'Title is required',
            },

        },
        submitHandler: function(form) {
            $.ajax({
                type: "POST",
                url: "/school/progress/updateSubProgress",
                processData: false,
                contentType: false,
                data: new FormData(form),
                success: function(response) {
                    console.log(response);
                    if (response.code == 200) {
                        swal({
                            icon: "success",
                            title: 'Sub-Progress Updated Successfully',
                            text: " ",
                            timer: 2000,
                            button: false,
                        })
                        $('#sub_progress_update_modal').modal('hide');
                        $('#view_details_progress_modal').modal('hide');
                    }

                }
            });

        }
    });



    function displayProgress() {
        $.ajax({
            type: "POST",
            url: "{{ route('retrieve.progress') }}",
            data: $(this).serialize(),
            success: function(response) {
                table = $('#table').DataTable({

                    order: [2, 'desc'],
                    data: JSON.parse(response),
                    columns: [{
                            data: 'title',
                        },
                        {
                            data: 'total_sub_progress',
                        },
                        {
                            data: 'date_created',
                        },
                        {
                            data: 'date_updated',
                            visible: false,
                        },
                        {

                            data: null,
                        },
                    ],
                    columnDefs: [{

                        data: null,
                        defaultContent: `<div class="dropdown">
                                            <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            </i>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item view-progress" href="#">View Sub-progress</a></li>
                                                <li><a class="dropdown-item update-progress" role="button">Update</a></li>
                                                <li><a class="dropdown-item delete" href="#">Delete</a></li>
                                            </ul>
                                        </div>`,
                        targets: -1
                    }],
                    // dom: 'Bfrtip',
                    // buttons: [{
                    //         extend: 'copy',
                    //         exportOptions: {
                    //             columns: ':visible:not(:last-child)'
                    //         },
                    //         title: 'List of Progress Items'
                    //     },
                    //     {
                    //         extend: 'csv',
                    //         exportOptions: {
                    //             columns: ':visible:not(:last-child)'
                    //         },
                    //         title: 'List of Progress Items'
                    //     },
                    //     {
                    //         extend: 'excel',
                    //         exportOptions: {
                    //             columns: ':visible:not(:last-child)'
                    //         },
                    //         title: 'List of Progress Items'
                    //     },
                    //     {
                    //         extend: 'pdf',
                    //         exportOptions: {
                    //             columns: ':visible:not(:last-child)' // Exclude hidden columns
                    //         },
                    //         customize: function(doc) {
                    //             // Adjust the width of the table in the PDF
                    //             doc.content[1].table.widths = Array(doc.content[1].table.body[0]
                    //                 .length + 1).join('*').split('');
                    //         },
                    //         title: 'List of Progress Items',

                    //     },
                    //     {
                    //         extend: 'print',

                    //         exportOptions: {
                    //             columns: ':visible:not(:last-child)' // Exclude hidden columns
                    //         },
                    //         title: 'List of Progress Items'
                    //     }
                    // ],

                });
            }
        });
    }

    function displaySubProgress(id) {

        $.ajax({
            type: "POST",
            url: "/school/progress/" + id + "/subprogress",
            data: $(this).serialize(),
            success: function(response) {
                if (subProgressTable) {
                    subProgressTable.destroy();
                }
                subProgressTable = $('#sub_progress_table').DataTable({
                    order: [2, 'desc'],
                    data: JSON.parse(response),
                    columns: [{
                            data: 'title',
                        },
                        {
                            data: 'date_created',
                        },
                        {
                            data: 'date_updated',
                            visible: false,
                        },
                        {
                            data: null,
                        },
                    ],
                    columnDefs: [{

                        data: null,
                        defaultContent: `<div class="dropdown">
                                            <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            </i>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item update-subProgress" role="button">Update</a></li>
                                                <li><a class="dropdown-item del-subprog" href="#">Delete</a></li>
                                            </ul>
                                        </div>`,
                        targets: -1
                    }],

                });
            }
        });
    }
    $('#modal_btn_add_progress').click(function(e) {
        $('#progress_form_modal').modal('show');
        resetForm();
        operation = "add";
    });
    $(document).on('click', '.view-progress', function() {
        $('#view_details_progress_modal').modal('show');
        selected_progress = $('#table').DataTable().row($(this).parents('tr'));
        let data = selected_progress.data();
        $('#modal_title_view').text(data.title);
        $('#progress_description').text(data.descriptions);
        displaySubProgress(data.id);
    });

    $(document).on('click', '.update-progress', function() {
        resetForm();
        selected_progress = $('#table').DataTable().row($(this).parents('tr'));
        let data = selected_progress.data();
        $('#progress_form_modal').modal('show');
        operation = "edit";
        $('#modal_title').html('Update Progress');
        $('#modal_add_submit').val('Save');
        $('#title').val(data.title);
        $('#description').val(data.descriptions);
    });






    function resetForm() {
        $('.check-label').css('display', 'none');
        $('.error').css('display', 'none');
        $('#progress_form').trigger("reset");
        $('#sub_progress_form').trigger("reset");
    }


    $(document).on('click', '#modal_btn_add_sub_progress', function() {
        $('#sub_progress_form_modal').modal('show');
        resetForm();
    });


    $(document).on('click', '.update-subProgress', function() {
        $('#sub_progress_update_modal').modal('show');
        selected_subprogress = $('#sub_progress_table').DataTable().row($(this).parents('tr'));
        let data = selected_subprogress.data();
        $('#subtitle').val(data.title);
        $('#subprog_id').val(data.id);

        resetForm();
    });


    $(document).on('click', '.delete', function() {
        data = $('#table').DataTable().row($(this).parents('tr'));
        const tempData = data.data();
        id = tempData.id;

        swal({
            title: "Delete Progress?",
            text: "Are you sure you want to delete progress?",
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
                    url: "{{ route('delete.progress') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        progress_id: id,
                    },
                    success: function(response) {
                        if (response.code == 200) {
                            swal({
                                icon: "success",
                                title: 'Progress Successfully Deleted',
                                text: " ",
                                timer: 2000,
                                showConfirmButton: false,
                            }).then(function() {
                                window.location.href =
                                    "{{ route('progress.index') }}";
                            });
                        } else {
                            if (response.code == 200) {
                                swal({
                                    icon: "error",
                                    title: `${response.message}`,
                                    text: " ",
                                    timer: 2000,
                                    showConfirmButton: false,
                                })
                            }
                        }
                    }
                });
            } else {

            }
        });

    });




    $(document).on('click', '.del-subprog', function() {
        data = $('#sub_progress_table').DataTable().row($(this).parents('tr'));
        const tempData = data.data();
        id = tempData.id;

        swal({
            title: "Delete Sub-Progress?",
            text: "Are you sure you want to delete sub-progress?",
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
                    url: "{{ route('delete.sub_progress') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        sub_progress_id: id,
                    },
                    success: function(response) {
                        if (response.code == 200) {
                            swal({
                                icon: "success",
                                title: 'Sub-Progress Successfully Deleted',
                                text: " ",
                                timer: 2000,
                                showConfirmButton: false,
                            }).then(function() {
                                window.location.href =
                                    "{{ route('progress.index') }}";
                            });
                        }
                    }
                });
            } else {

            }
        });

    });
</script>
@include(SchoolFileHelper::$footer)
