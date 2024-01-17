@include('admin.includes.header', ['title' => 'Admin Management'])

<div class="container-fluid" style="padding: 20px;margin-top:60px">
    <div class="row">
        <div class="col-12">
            <div class="w-100 d-flex justify-content-between table-header-btn">
                <div class="d-flex" style="gap:15px">
                    <!-- <button class="btn-outline-light"><i class="fa-solid fa-file-export"></i>Export CSV</button>
                    <button class="btn-outline-light"><i class="fa-solid fa-file-export"></i>Import CSV</button> -->
                </div>
                <a href="{{ route('create.admin') }}" class="btn-add-management">
                    <button id="modal_btn" class="btn-add-management"><i class="fa-solid fa-plus"></i> Add new
                        admin</button>
                </a>
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

<script>
    displayAdmin();

    function displayAdmin() {

        table = $('#table').DataTable({
            order: [5, 'desc'],
            data: JSON.parse(`<?php echo json_encode($admins); ?>`),
            columns: [{
                    data: function(data, type, row) {
                        return `
                                <div class="d-flex align-items-center" style="gap: 10px;padding:5px 0">
                    <img src="/` + data.profile_image + `" class="rounded-circle"
                        style="width: 40px;height:40px" alt="Avatar" />
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
                    data: null,
                    render: function(data, type, row) {
                        return "Active";
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
                                                <li><a class="dropdown-item" href="#">More Details</a></li>
                                                <li><a class="dropdown-item" href="/admin/admin/${data.admin_id}/update">Update</a></li>
                                                <li><a class="dropdown-item delete" href="#">Delete</a></li>
                                            </ul>
                                        </div>`;
                    }
                },
            ],


        });

    }





    $(document).on('click', '.delete', function() {
        data = $('#table').DataTable().row($(this).parents('tr'));
        const tempData = data.data();
        id = tempData.admin_id;

        swal({
            title: "Delete Admin?",
            text: "Are you sure you want to delete Admin? ",
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
                    url: "{{ route('delete.admin') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        admin_id: id,
                    },
                    success: function(response) {
                        if (response.code == 200) {
                            swal({
                                icon: "success",
                                title: 'Admin Successfully Deleted',
                                text: " ",
                                timer: 2000,
                                showConfirmButton: false,
                            }).then(function() {
                                window.location.href =
                                    "{{ route('admin.retreive.adminAccounts') }}";
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