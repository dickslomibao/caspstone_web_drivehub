@include(SchoolFileHelper::$header, ['title' => 'Staff Management'])

<div class="container-fluid" style="padding: 20px;margin-top:60px">
    <div class="row">
        <div class="col-12">
            <div class="w-100 d-flex justify-content-between table-header-btn">
                <div class="d-flex" style="gap:15px">
                    <a class="btn-outline-light" href="{{ route('staff.export.pdf') }}"><i
                            class="fa-solid fa-file-export"></i>Export
                        PDF</a>
                    <!--  <button class="btn-outline-light"><i class="fa-solid fa-file-export"></i>Import CSV</button> -->
                </div>
                <a href="{{ route('create.staff') }}" class="btn-add-management">
                    <button id="modal_btn" class="btn-add-management"><i class="fa-solid fa-plus"></i> Add new
                        staff</button>
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
@if (session('staff_message'))
    <script>
        Toastify({
            text: "{{ session('staff_message') }}",
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
    displayStaff();

    function displayStaff() {

        table = $('#table').DataTable({

            order: [5, 'desc'],
            data: JSON.parse(`<?php echo json_encode($staffs); ?>`),
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
                    data: null,
                    render: function(data, type, row) {
                        if (data.status == 5) {
                            return 'Promoted'
                        }
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
                        if (data.status == 5) {
                            return "";
                        }
                        return `<div class="dropdown">
                                            <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                               
                                            </i>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="/school/staff/${data.staff_id}/update">Update</a></li>
                                                <li><a class="dropdown-item delete" href="#">Delete</a></li>
                                                <li><a class="dropdown-item" onclick="r= confirm('Are you sure you want to promote ? it cannot be undo.');if(r==true){location.href='/school/staff/${data.staff_id}/promote';}">Promote as instructor</a></li>
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
            //         title: 'List of Staffs',
            //     },
            //     {
            //         extend: 'csv',
            //         exportOptions: {
            //             columns: ':visible:not(:last-child)'
            //         },
            //         title: 'List of Staffs'
            //     },
            //     {
            //         extend: 'excel',
            //         exportOptions: {
            //             columns: ':visible:not(:last-child)'
            //         },
            //         title: 'List of Staffs'
            //     },
            //     {
            //         extend: 'pdf',
            //         exportOptions: {
            //             columns: ':visible:not(:last-child)' // Exclude hidden columns
            //         },
            //         title: 'List of Staffs',

            //     },
            //     {
            //         extend: 'print',

            //         exportOptions: {
            //             columns: ':visible:not(:last-child)' // Exclude hidden columns
            //         },
            //         title: 'List of Staffs'
            //     }
            // ],


        });

    }





    $(document).on('click', '.delete', function() {
        data = $('#table').DataTable().row($(this).parents('tr'));
        const tempData = data.data();
        id = tempData.staff_id;

        swal({
            title: "Delete Staff?",
            text: "Are you sure you want to delete Staff? ",
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
                    url: "{{ route('delete.staff') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        staff_id: id,
                    },
                    success: function(response) {
                        if (response.code == 200) {
                            swal({
                                icon: "success",
                                title: 'Staff Successfully Deleted',
                                text: " ",
                                timer: 2000,
                                showConfirmButton: false,
                            }).then(function() {
                                window.location.href =
                                    "{{ route('index.staff') }}";
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
