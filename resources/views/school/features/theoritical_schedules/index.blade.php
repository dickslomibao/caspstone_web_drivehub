@include(SchoolFileHelper::$header, ['title' => 'Theroritical Schedules'])

<div class="container-fluid" style="padding: 20px;margin-top:50px">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-sm-2"> <label for="">Status</label>
                    <select id="status" class='form-select mb-3' name="status" required>
                        <option value="0" selected>All</option>
                        <option value="1">Waiting</option>
                        <option value="2">Started</option>
                        <option value="3">Completed</option>
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
                    <center><br><button type="submit" id="filterbutton" class="btn btn-primary" style="background-color: var(--primaryBG);border:none">Filter</button></center>
                </div>
            </div>
            <div id="filterresult">
                <div class="w-100 d-flex align-items-center justify-content-between table-header-btn">
                    <div class="d-flex" style="gap:15px">
                        <a class="btn-outline-light" href="{{route('theoreticalSched.export.pdf')}}"><i
                                class="fa-solid fa-file-export" ></i>Export
                            PDF</a>
                    </div>
                    <a href="{{ route('create.theoritical') }}">
                        <button class="btn-add-management" id="modal_btn" onclick=""><i class="fa-solid fa-plus"></i>
                            Create new
                            Schedules </button></a>
                </div>
                <table id="table" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Slots</th>
                            <th>Scheduled Date</th>

                            <th width="120">Status</th>
                            <th>Date Created</th>
                            <th>Date Update</th>
                            <th width="50">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $('#table').hide();
    displayTheoriticalSchedules();

    function displayTheoriticalSchedules() {
        $.ajax({
            type: "POST",
            url: "{{ route('get.theoritical') }}",
            success: function(response) {
                $('#table').show();
                table = $('#table').DataTable({
         
                    order: [6, 'desc'],
                    data: JSON.parse(response),
                    columns: [{
                            data: 'title'
                        },
                        {
                            data: 'slot',
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                var birthdate = moment(data.start_date).format(
                                        'MMMM D, YYYY | hh:mm:ss A') + moment(data.end_date)
                                    .format(
                                        ' - hh:mm:ss A');
                                return birthdate;
                            }
                        },
                        // {
                        //     data: 'end_date',
                        //     render: function(data, type, row) {
                        //         var birthdate = moment(data).format(
                        //             'MMMM D, YYYY - hh:mm:ss A');
                        //         return birthdate;
                        //     }
                        // },
                        {
                            data: null,
                            render: function(data, type, row) {
                                if (data.status == 1) {
                                    return '<span class="waiting">Waiting</span>';
                                }
                                if (data.status == 2) {
                                    return '<span class="started">Started</span>';
                                }
                                if (data.status == 3) {
                                    return '<span class="completed">Completed</span>';
                                }
                                return "";
                            }
                        },
                        {
                            data: 'date_created',
                            render: function(data, type, row) {
                                var birthdate = moment(data).format(
                                    'MMMM D, YYYY');
                                return birthdate;
                            },
                            visible: false,
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
                                                <li><a class="dropdown-item" href="/school/theoritical/${data.id}/view">View Schedules</a></li>
                                                <li><a class="dropdown-item" href="/school/theoritical/${data.id}/update" role="button">Update</a></li>
                                                <li><a class="dropdown-item" href="#">Delete</a></li>
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
                    //         }
                    //     },
                    //     {
                    //         extend: 'csv',
                    //         exportOptions: {
                    //             columns: ':visible:not(:last-child)'
                    //         }
                    //     },
                    //     {
                    //         extend: 'excel',
                    //         exportOptions: {
                    //             columns: ':visible:not(:last-child)'
                    //         }
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
                    //         }


                    //     },
                    //     {
                    //         extend: 'print',

                    //         exportOptions: {
                    //             columns: ':visible:not(:last-child)' // Exclude hidden columns
                    //         }
                    //     }
                    // ]

                });
            }
        });
    }




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
                url: '{{route("school.filter.theoreticalSched")}}',
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