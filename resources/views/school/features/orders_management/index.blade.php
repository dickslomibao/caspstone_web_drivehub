@include(SchoolFileHelper::$header, ['title' => 'Orders and Payment'])

<div class="container-fluid" style="padding: 20px;margin-top:50px">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-sm-2"> <label for="">Status</label>
                    <select id="status" class='form-select mb-3' name="status" required>
                        <option value="0" selected>All</option>
                        <option value="1">Pending Orders</option>
                        <option value="2">To Pay</option>
                        <option value="3">Waiting for requirements</option>
                        <option value="4">Courses Ongoing</option>
                        <option value="5">Order Completed</option>
                        <option value="6">Cancelled</option>
                        <option value="7">Refunded</option>
                    </select>
                </div>
                <div class="col-sm-3" id="changeradio">
                    <label for="">Payment Method</label>
                    <select id="payment" class='form-select mb-3' name="payment" required>
                        <option value="0" selected>All</option>
                        <option value="1">Cash</option>
                        <option value="2">GCash</option>
                        <option value="3">Credit Card</option>

                    </select>
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
                <div class="w-100 d-flex align-items-center justify-content-between table-header-btn">

                    <div class="d-flex" style="gap:15px">
                        <a class="btn-outline-light" href="{{ route('orders.payment.export.pdf') }}"><i
                                class="fa-solid fa-file-export"></i>Export
                            PDF</a>
                    </div>
                    <a href=""><button class="btn-add-management" id="modal_btn"><i class="fa-solid fa-plus"></i> Add new
                        Orders</button></a>
                </div>
                <table id="table" class="table" style="width:100%;min-width:900px;overflow:auto">
                    <thead>
                        <tr>
                            <th>Student name</th>
                            <th>Total amount</th>
                            <th>Payment method</th>
                            <th>Status</th>
                            <th>Date Ordered</th>
                            <th>Date Updated</th>
                            <th width="50">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    let orderTable = null;
    displayOrders();

    function displayOrders() {
        $.ajax({
            type: "POST",
            url: "{{ route('school.orders') }}",
            data: $(this).serialize(),
            success: function(response) {
                orderTable = $('#table').DataTable({

                    order: [5, 'desc'],
                    data: JSON.parse(response),
                    columns: [{
                            data: function(data, type, row) {
                                return `
                                <div class="d-flex align-items-center" style="gap: 10px;padding:5px 0">
                                    <img src="/${data.profile_image}" class="rounded-circle" style="width: 40px;height:40px" alt="Avatar" />
                                    <div>
                                        <h6>${data.firstname} ${data.middlename ?? ""} ${data.lastname}</h6>
                                        <p style="font-size:14px" class="email">${data.email}</p>
                                    </div>
                                </div>`;
                            }
                        },
                        {
                            data: function(data, type, row) {
                                return data.total_amount.toFixed(2);
                            }
                        },
                        {
                            data: function(data, type, row) {
                                switch (data.payment_type) {
                                    case 1:
                                        if (data.status == 1) {
                                            return "Cash";
                                        }
                                        if (data.status != 6) {
                                            let balance = data.total_amount - data
                                                .total_paid;
                                            if (data.status == 7) {

                                                return `Cash<br>Refunded Amount: ${(data.total_amount - balance).toFixed(2)}`;

                                            } else {
                                                if (balance == 0) {
                                                    return 'Cash<br>Payment Completed';
                                                } else {
                                                    return ` Cash<br>Balance: ${balance.toFixed(2)}`;
                                                }
                                            }
                                        }
                                    case 2:
                                        return "Gcash";
                                        if (data.status == 7) {
                                            return `Gcash<br>Refunded Amount: ${(data.total_amount).toFixed(2)}`;
                                        }
                                    case 3:
                                        return "Credit Card";
                                        if (data.status == 7) {
                                            return `Credit Card<br>Refunded Amount: ${(data.total_amount).toFixed(2)}`;
                                        }
                                    default:
                                        return "";
                                }
                            }
                        },
                        {
                            data: function(data, type, row) {
                                switch (data.status) {
                                    case 1:
                                        return "Pending Orders";
                                    case 2:
                                        return "To Pay";
                                    case 3:
                                        return "Waiting for requirements";
                                    case 4:
                                        return "Courses Ongoing";
                                    case 5:
                                        return "Order Completed";
                                    case 6:
                                        return "Cancelled";
                                    case 7:
                                        return "Refunded";
                                    default:
                                        return "";
                                }
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
                            data: function(data, type, row) {
                                return `<div class="dropdown">
                                        <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="/school/orders/${data.id}/view">View Order</a></li>
                                        </ul>
                                    </div>`;
                            },
                        },
                    ],
                    // dom: 'Bfrtip',
                    // buttons: [{
                    //         extend: 'copy',
                    //         exportOptions: {
                    //             columns: ':visible:not(:last-child)'
                    //         },
                    //         title: 'List of Orders & Payments',
                    //     },
                    //     {
                    //         extend: 'csv',
                    //         exportOptions: {
                    //             columns: ':visible:not(:last-child)'
                    //         },
                    //         title: 'List of Orders & Payments'
                    //     },
                    //     {
                    //         extend: 'excel',
                    //         exportOptions: {
                    //             columns: ':visible:not(:last-child)'
                    //         },
                    //         title: 'List of Orders & Payments'
                    //     },
                    //     {
                    //         extend: 'pdf',
                    //         exportOptions: {
                    //             columns: ':visible:not(:last-child)' // Exclude hidden columns
                    //         },
                    //         title: 'List of Orders & Payments',
                    //     },
                    //     {
                    //         extend: 'print',
                    //         exportOptions: {
                    //             columns: ':visible:not(:last-child)' // Exclude hidden columns
                    //         },
                    //         title: 'List of Orders & Payments'
                    //     }
                    // ],
                });
            }
        });
    }




    $('#filterbutton').click(function() {
        var status = $('#status').val();
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        var payment = $('#payment').val();

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
        }  else {
            $.ajax({
                url: '{{ route('school.filter.ordersPayment') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status,
                    start_date,
                    end_date,
                    payment: payment,
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
