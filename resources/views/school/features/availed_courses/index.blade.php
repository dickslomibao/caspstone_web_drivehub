@include(SchoolFileHelper::$header, ['title' => 'Availed Courses'])

<div class="container-fluid" style="padding: 20px;margin-top:60px">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-sm-2"> <label for="">Status</label>
                    <select id="status" class='form-select mb-3' name="status" required>
                        <option value="0" selected>All</option>
                        <option value="1">Waiting</option>
                        <option value="2">Ongoing</option>
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
                    <center><br><button type="submit" id="filterbutton" class="btn btn-primary" style="background-color: var(--primaryBG);border:none">Filter</button>
                    </center>
                </div>
            </div>
            <div id="filterresult">
                <div class="w-100 d-flex justify-content-between table-header-btn">
                    <div class="d-flex" style="gap:15px">
                        <a class="btn-outline-light" href="{{ route('availed.courses.export.pdf') }}"><i
                                class="fa-solid fa-file-export"></i>Export
                            PDF</a>
                    </div>

                </div>
                <table id="table" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Student name</th>
                            <th>Type</th>
                            <th>Course</th>

                            <th>Duration</th>
                            <th>Remarks</th>
                            <th width="120">Status</th>
                            <th>Date Created</th>
                            <th width="50">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade modal-lg" id="scheduleView" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" id="exampleModalLabel">Sessions Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="" style="padding: 20px 7px" id="body">

            </div>
        </div>
    </div>
</div>
<script>
    let table;
    displayAvailed();

    function displayAvailed() {
        table = $('#table').DataTable({

            order: [4, 'desc'],
            data: JSON.parse(`<?php echo json_encode($availed_courses); ?>`),
            columns: [{
                    data: function(data, type, row) {
                        return `
                                <div class="d-flex align-items-center" style="gap: 10px;padding:5px 0">
                    <img src="/${data.profile_image}" class="rounded-circle"
                        style="width: 40px;height:40px" alt="Avatar" />
                        <div>
                            <h6>${data.firstname} ${data.middlename ?? ""} ${data.lastname}</h6>
                            <p style="font-size:14px" class="email">${data.email}</p>
                            </div>
                </div>                             
                                `;
                    }

                },
                {
                    data: null,
                    render: function(data, type, row) {
                        if (data.type == 1) {
                            return 'Practical'
                        }
                        if (data.type == 2) {
                            return 'Theoritical'
                        }

                        return "";
                    }
                },
                {
                    data: 'name'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        console.log(data);
                        return `${data.duration} hrs <br> <a role="button" onclick="show(${data.id});" style="color:var(--primaryBG)">${data.session} session</a>`;
                    }
                },
                {
                    data: 'remarks',
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        if (data.status == 1) {
                            return '<span class="waiting">Waiting</span>';
                        }
                        if (data.status == 2) {
                            return '<span class="started">Ongoing</span>';
                        }
                        if (data.status == 3) {
                            return `<span class="completed">Completed</span>`;
                        }
                        return "";
                    }
                },
                {
                    data: 'date_created',
                    render: function(data, type, row) {
                        var birthdate = moment(data).format(
                            'MMM D, YYYY - hh:mm a');
                        return birthdate;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<div class="dropdown">
                                            <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                               
                                            </i>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="/availed/courses/${data.id}/view">View</a></li>
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
            //         orientation: 'landscape',
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
                url: '{{ route('school.filter.availedCourses') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status,
                    start_date,
                    start_date,
                    end_date,
                    end_date
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

    function show(id) {
        $('#scheduleView').modal('show');
        $('#body').html(`<center><h5>Loading...</h5></center>`);
        $.ajax({
            method: 'POST',
            url: "{{ route('view.sessions') }}",
            data: {
                'id': id
            },
            success: function(response) {
                console.log(response);
                $('#body').html(response);
            }
        });
    }
</script>
@include(SchoolFileHelper::$footer)
