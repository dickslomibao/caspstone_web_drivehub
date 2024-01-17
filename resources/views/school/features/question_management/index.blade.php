@include(SchoolFileHelper::$header, ['title' => 'Question Management'])
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
                    <center><br><button type="submit" id="filterbutton" style="background: var(--primaryBG)"
                            class="btn btn-primary">Filter</button>
                    </center>
                </div>
            </div>
            <div id="filterresult">
                <div class="w-100 d-flex justify-content-between table-header-btn">
                    <div class="d-flex" style="gap:15px">
                        <a class="btn-outline-light" href="{{ route('question.export.pdf') }}"><i
                                class="fa-solid fa-file-export"></i>Export
                            PDF</a>
                    </div>
                    <a href="{{ route('create.question') }}">
                        <button class="btn-add-management" id="modal_btn"><i class="fa-solid fa-plus"></i> Add new
                            question</button>
                    </a>
                </div>
                <table id="table" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Question</th>
                            <th>Answer</th>
                            <th width="100">Status</th>
                            <th>Date Created</th>
                            <th width="50">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    displayQuestions();

    function displayQuestions() {
        $.ajax({
            type: "POST",
            url: "{{ route('get.question') }}",

            success: function(response) {
                table = $('#table').DataTable({

                    order: [3, 'desc'],
                    data: response,
                    columns: [{
                            data: 'questions'
                        },
                        {
                            data: 'answer_body'
                        },

                        {
                            data: function(data, type, row) {
                                switch (data.status) {
                                    case 1:
                                        return `<span class="available">&#8226 Available</span>`;
                                    case 2:
                                        return `<span class="
                    not - available ">&#8226 Not available</span>`;
                                    default:
                                        return "";
                                }
                            }
                        },

                        {
                            data: 'date_created',
                            render: function(data, type, row) {
                                return moment(data).format(
                                    'MMM D, YYYY | hh:mm A');
                            }
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return `<div class="dropdown">
                                <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                   
                                </i>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="">More Details</a></li>
                                    <li><a class="dropdown-item update" href="/school/question/update/page/${data.id}" role="button">Update</a></li>
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
                    //         title: 'List of Questions',
                    //     },
                    //     {
                    //         extend: 'csv',
                    //         exportOptions: {
                    //             columns: ':visible:not(:last-child)'
                    //         },
                    //         title: 'List of Questions'
                    //     },
                    //     {
                    //         extend: 'excel',
                    //         exportOptions: {
                    //             columns: ':visible:not(:last-child)'
                    //         },
                    //         title: 'List of Questions'
                    //     },
                    //     {
                    //         extend: 'pdf',
                    //         exportOptions: {
                    //             columns: ':visible:not(:last-child)' // Exclude hidden columns
                    //         },
                    //         title: 'List of Questions',
                    //     },
                    //     {
                    //         extend: 'print',

                    //         exportOptions: {
                    //             columns: ':visible:not(:last-child)' // Exclude hidden columns
                    //         },
                    //         title: 'List of Questions'
                    //     }
                    // ],
                });
            }
        });


    }



    $(document).on('click', '.delete', function() {
        data = $('#table').DataTable().row($(this).parents('tr'));
        const tempData = data.data();
        id = tempData.id

        swal({
            title: "Delete Question?",
            text: "Are you sure you want to delete Question? ",
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
                    url: "{{ route('delete.question') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        question_id: id,
                    },
                    success: function(response) {
                        if (response.code == 200) {
                            swal({
                                icon: "success",
                                title: 'Question Successfully Deleted',
                                text: " ",
                                timer: 2000,
                                showConfirmButton: false,
                            }).then(function() {
                                window.location.href =
                                    "{{ route('index.question') }}";
                            });
                        } else {
                            swal({
                                icon: "error",
                                title: `${response['message']}`,
                                text: " ",
                                timer: 2000,

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
        }else if (endDateObj > currentDate) {
            ///revision
            swal({
                icon: "error",
                title: 'End Date should be equal to or less than the current date',
                text: " ",
            });
        } else {
            $.ajax({
                url: '{{ route('school.filter.questions') }}',
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
