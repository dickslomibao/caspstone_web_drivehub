@include(SchoolFileHelper::$header, ['title' => 'Promo Management'])

<div class="container-fluid" style="padding: 20px;margin-top:60px">
    <div class="row">
        <div class="col-12">
            <div class="row">

                <div class="col-lg-5"><label for="" style="font-weight: 500;margin-bottom:5px">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control mb-3" required>
                </div>
                <div class="col-lg-6"> <label for="" style="font-weight: 500;margin-bottom:5px">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control mb-3" required>
                </div>
                <div class="col-lg-1">
                    <button type="submit" id="filterbutton" class="btn btn-primary w-100"
                        style="background: var(--primaryBG)">Filter</button>

                </div>
            </div>
            <div id="filterresult">

                <div class="w-100 d-flex justify-content-between table-header-btn">
                    <div class="d-flex" style="gap:15px">
                        <a class="btn-outline-light" href="{{ route('promo.export.pdf') }}"><i
                                class="fa-solid fa-file-export"></i>Export
                            PDF</a>
                    </div>
                    <a href="{{ route('create.promo') }}" class="btn-add-management">
                        <button id="modal_btn" class="btn-add-management">
                            <i class="fa-solid fa-plus"></i> Add new promo
                        </button>
                    </a>
                </div>

                <table id="table" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Start date</th>
                            <th>End date</th>
                            <th>Date Created</th>
                            <th style="width: 60px">Action</th>
                        </tr>
                    </thead>
                </table>

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
    displayPromo();

    function displayPromo() {
        table = $('#table').DataTable({
            order: [4, 'desc'],
            data: JSON.parse(`<?php echo json_encode($promo); ?>`),
            columns: [{
                    data: 'name'
                },
                {
                    data: 'price'
                },
                {
                    data: 'start_date',
                    render: function(data, type, row) {
                        return moment(data).format(
                            'MMMM D, YYYY | hh:mm:ss A');

                    }
                },
                {
                    data: 'end_date',
                    render: function(data, type, row) {
                        return moment(data).format(
                            'MMMM D, YYYY | hh:mm:ss A');

                    }
                },
                {
                    data: 'date_created',
                    visible: false,

                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<div class="dropdown">
                                            <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                               
                                            </i>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="/school/promo/${data.id}/view">More Details</a></li>
                                                <li><a class="dropdown-item update" role="button" href="/school/promo/${data.id}/updateView">Update</a></li>
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
            //         title: 'List of Promos',
            //     },
            //     {
            //         extend: 'csv',
            //         exportOptions: {
            //             columns: ':visible:not(:last-child)'
            //         },
            //         title: 'List of Promos'
            //     },
            //     {
            //         extend: 'excel',
            //         exportOptions: {
            //             columns: ':visible:not(:last-child)'
            //         },
            //         title: 'List of Promos'
            //     },
            //     {
            //         extend: 'pdf',
            //         exportOptions: {
            //             columns: ':visible:not(:last-child)' // Exclude hidden columns
            //         },
            //         title: 'List of Promos',
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
            //         title: 'List of Promos'
            //     }
            // ],


        });

    }


    $(document).on('click', '.delete', function() {
        data = $('#table').DataTable().row($(this).parents('tr'));
        const tempData = data.data();
        id = tempData.id;

        swal({
            title: "Delete Promo?",
            text: "Are you sure you want to delete promo? ",
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
                    url: "",
                    data: {
                        _token: '{{ csrf_token() }}',
                        promo_id: id,
                    },
                    success: function(response) {
                        if (response.code == 200) {
                            swal({
                                icon: "success",
                                title: 'Promo Successfully Deleted',
                                text: " ",
                                timer: 2000,
                                showConfirmButton: false,
                            }).then(function() {
                                window.location.href =
                                    "{{ route('index.promo') }}";
                            });
                        }
                    }
                });
            } else {

            }
        });

    });

    $('#filterbutton').click(function() {
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
        }else if (endDateObj > currentDate) {
            ///revision
            swal({
                icon: "error",
                title: 'End Date should be equal to or less than the current date',
                text: " ",
            });
        } else {
            $.ajax({
                url: '{{ route('school.filter.promo') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
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
