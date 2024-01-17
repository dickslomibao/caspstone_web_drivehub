@include('admin.includes.header', ['title' => 'Terms of Services Management'])





<div class="container-fluid" style="padding: 20px;margin-top:60px">
    <div class="row">
        <div class="col-12">
            <div class="w-100 d-flex justify-content-between table-header-btn">
                <div class="d-flex" style="gap:15px">
                    <!-- <button class="btn-outline-light"><i class="fa-solid fa-file-export"></i>Export CSV</button>
                    <button class="btn-outline-light"><i class="fa-solid fa-file-export"></i>Import CSV</button> -->
                </div>
                <button class="btn-add-management" id="modal_btn_add_terms"><i class="fa-solid fa-plus"></i> Add new
                    Terms</button>
            </div>
            <table id="table" class="table" style="width:100%">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Date Created</th>
                        <th>Date update</th>
                        <th width="50">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="terms_form_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" id="modal_title">Add New Terms</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="terms_form">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Title: <i id="check-title"
                                                    class="fa-solid fa-check check-label" style=""></i></label>
                                            <input type="text" class="form-control" id="title" name="title" required
                                                placeholder="Enter terms title..." />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description: <i
                                                    id="check-description" class="fa-solid fa-check check-label"
                                                    style=""></i></label>
                                            <textarea class="form-control" rows="5" id="description" name="description"
                                                required placeholder="Enter terms description..."></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div style="padding:0 0 20px 0;">
                                    <div class="row justify-content-end">
                                        <div class="col-12">
                                            <input type="submit" class="btn-form" id="modal_add_submit"
                                                value="Add Terms">
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
let selected_terms;

displayTerms();
let formValidation = $("#terms_form").validate({
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
        let url = operation == "add" ? "{{ route('terms.create') }}" : "/admin/terms/" +
            selected_terms.data().id + "/update"
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
                        }).then(function() {
                            $('#terms_form_modal').modal('hide');
                            window.location.href =
                                "{{ route('index.terms') }}";
                        });
                    } else {
                        swal({
                            icon: "success",
                            title: 'Updated Successfully',
                            text: " ",
                            timer: 2000,
                            button: false,
                        }).then(function() {
                            $('#terms_form_modal').modal('hide');
                            window.location.href =
                                "{{ route('index.terms') }}";
                        });
                    }



                }

            }
        });

    }
});



function displayTerms() {
    $.ajax({
        type: "POST",
        url: "{{ route('retrieve.terms') }}",
        data: $(this).serialize(),
        success: function(response) {
            table = $('#table').DataTable({
                order: [2, 'desc'],
                data: JSON.parse(response),
                columns: [{
                        data: 'title',
                    },
                    {
                        data: 'description',
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
                                                <li><a class="dropdown-item update-terms" role="button">Update</a></li>
                                                <li><a class="dropdown-item delete" href="#">Delete</a></li>
                                            </ul>
                                        </div>`,
                    targets: -1
                }],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        },
                        title: 'DriveHub\'s Terms of Service'
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        },
                        title: 'DriveHub\'s Terms of Service'
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':visible:not(:last-child)'
                        },
                        title: 'DriveHub\'s Terms of Service'
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':visible:not(:last-child)' // Exclude hidden columns
                        },
                        customize: function(doc) {
                            // Adjust the width of the table in the PDF
                            doc.content[1].table.widths = Array(doc.content[1].table.body[0]
                                .length + 1).join('*').split('');
                        },
                        title: 'DriveHub\'s Terms of Service',

                    },
                    {
                        extend: 'print',

                        exportOptions: {
                            columns: ':visible:not(:last-child)' // Exclude hidden columns
                        },
                        title: 'DriveHub\'s Terms of Service'
                    }
                ],

            });
        }
    });
}




$('#modal_btn_add_terms').click(function(e) {
    $('#terms_form_modal').modal('show');
    resetForm();
    operation = "add";
});



$(document).on('click', '.update-terms', function() {
    resetForm();
    selected_terms = $('#table').DataTable().row($(this).parents('tr'));
    let data = selected_terms.data();
    $('#terms_form_modal').modal('show');
    operation = "edit";
    $('#modal_title').html('Update Progress');
    $('#modal_add_submit').val('Save');
    $('#title').val(data.title);
    $('#description').val(data.description);
});






function resetForm() {
    $('.check-label').css('display', 'none');
    $('.error').css('display', 'none');
    $('#terms_form').trigger("reset");
}


$(document).on('click', '.delete', function() {
    data = $('#table').DataTable().row($(this).parents('tr'));
    const tempData = data.data();
    id = tempData.id;

    swal({
        title: "Delete Progress?",
        text: "Are you sure you want to delete terms?",
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
                url: "{{ route('delete.terms') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    progress_id: id,
                },
                success: function(response) {
                    if (response.code == 200) {
                        swal({
                            icon: "success",
                            title: 'Terms Successfully Deleted',
                            text: " ",
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(function() {
                            window.location.href =
                                "{{ route('index.terms') }}";
                        });
                    }
                }
            });
        } else {

        }
    });

});
</script>


@include('admin.includes.footer')