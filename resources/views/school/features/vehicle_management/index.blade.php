@include(SchoolFileHelper::$header, ['title' => 'Vehicle Management'])

<div class="container-fluid" style="padding: 20px;margin-top:60px">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-2"> <label for="type" class="form-label">Vehicle Type: </label>
                    <select class="form-select" name="typeFilter" id="typeFilter" required>
                        <option selected value="" style="display: none">Select type</option>
                        <option value="MOTORCYCLE">MOTORCYCLE</option>
                        <option value="CARS">CAR</option>
                        <option value="TRUCK">TRUCK</option>
                    </select>
                </div>
                <div class="col-sm-3" id="changeradio">

                </div>
                <div class="col-sm-3">
                    <label for="transmission" class="form-label">Transmission:</label>
                    <select class="form-select" name="transmissionFilter" id="transmissionFilter" required>
                        <option selected value="" style="display: none">Select
                            transmission</option>
                        <option value="AUTOMATIC">AUTOMATIC</option>
                        <option value="MANUAL">MANUAL</option>
                        <option value="HYBRID">HYBRID</option>
                    </select>
                </div>
                <div class="col-sm-3"><label for="fuel" class="form-label">Fuel: </label>
                    <select class="form-select" name="fuelFilter" id="fuelFilter" required>
                        <option selected value="" style="display: none">Select
                            fuel</option>
                        <option value="DIESEL">DIESEL</option>
                        <option value="GASOLINE">GASOLINE</option>
                        <option value="ELECTRIC">ELECTRIC</option>
                    </select>
                </div>
                <div class="col-sm-1 d-flex align-items-center justify-content-end" class="" style="flex-direction: column;">
                    <button type="submit" id="filterbutton" class="btn btn-primary" style="background-color: var(--primaryBG);border:none">Filter</button>
                </div>
            </div>

            <div id="filterresult" style="margin-top: 20px">
                <div class="w-100 d-flex justify-content-between table-header-btn">
                    <div class="d-flex" style="gap:15px">
                        <a class="btn-outline-light" href="{{route('vehicles.export.pdf')}}"><i
                                class="fa-solid fa-file-export"></i>Export
                            PDF</a>
                    </div>
                    <button class="btn-add-management" id="modal_btn"><i class="fa-solid fa-plus"></i> Add new
                        vehicle</button>
                </div>
                <table id="table" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Vehicle Name</th>
                            <th>Plate Number</th>
                            <th>Manufacturer</th>
                            <th>Model</th>
                            <th>Year</th>
                            <th>Transmission</th>
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

<div class="modal fade modal-lg" id="vehicleModalForm" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" id="modal_title">Add New Vehicle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="vehicleForm">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="plate" class="form-label">Vehicle Name: <i id="check-name"
                                                    class="fa-solid fa-check check-label" style=""></i></label>
                                            <div>
                                                <input type="text" class="form-control" name="name" id="name" id="name"
                                                    placeholder="Enter car name..." required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="type" class="form-label">Vehicle Type: <i id="check-type"
                                                    class="fa-solid fa-check check-label" style=""></i></label>
                                            <select class="form-select" name="type" id="type"
                                                aria-label="Default select example" required>
                                                <option selected value="" style="display: none">Select type
                                                </option>
                                                <option value="MOTORCYCLE">MOTORCYCLE</option>
                                                <option value="CARS">CAR</option>
                                                <option value="TRUCK">TRUCK</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="plate" class="form-label">Plate number: <i id="check-plate"
                                                    class="fa-solid fa-check check-label" style=""></i></label>
                                            <div>
                                                <input type="text" class="form-control" name="plate" id="plate"
                                                    id="plate" placeholder="Enter plate number..." required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="manufacturer" class="form-label">Manufacturer: <i
                                                    id="check-manufacturer" class="fa-solid fa-check check-label"
                                                    style=""></i></label>
                                            <div>
                                                <input type="text" class="form-control" name="manufacturer"
                                                    id="manufacturer" id="manufacturer"
                                                    placeholder="Enter manufacturer..." required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="model" class="form-label">Model<i id="check-model"
                                                    class="fa-solid fa-check check-label" style=""></i></label>
                                            <input type="text" class="form-control" id="model" name="model"
                                                placeholder="Enter model..." required />
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="year" class="form-label">Year: <i id="check-year"
                                                    class="fa-solid fa-check check-label" style=""></i></label>
                                            <input type="number" class="form-control" id="year" name="year" required
                                                placeholder="Enter year..." />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="transmission" class="form-label">Transmission: <i
                                                    id="check-transmission" class="fa-solid fa-check check-label"
                                                    style=""></i></label>
                                            <select class="form-select" name="transmission" id="transmission"
                                                aria-label="Default select example" required>
                                                <option selected value="" style="display: none">Select
                                                    transmission</option>
                                                <option value="AUTOMATIC">AUTOMATIC</option>
                                                <option value="MANUAL">MANUAL</option>
                                                <option value="HYBRID">HYBRID</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="fuel" class="form-label">Fuel: <i id="check-fuel"
                                                    class="fa-solid fa-check check-label" style=""></i></label>
                                            <select class="form-select" name="fuel" id="fuel"
                                                aria-label="Default select example" required>
                                                <option selected value="" style="display: none">Select
                                                    fuel</option>
                                                <option value="DIESEL">DIESEL</option>
                                                <option value="GASOLINE">GASOLINE</option>
                                                <option value="ELECTRIC">ELECTRIC</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="color" class="form-label">Color: <i id="check-color"
                                                    class="fa-solid fa-check check-label" style=""></i></label>
                                            <input type="text" class="form-control" id="color" name="color" required
                                                placeholder="Enter color..." />
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="images" class="form-label">Vehicle Image: <i id="check-images"
                                                    class="fa-solid fa-check check-label" style=""></i></label>
                                            <input type="file" class="form-control" id="images" name="images"
                                                required />
                                        </div>
                                    </div>
                                </div>

                                <div style="padding:20px 0;">
                                    <div class="row justify-content-end">
                                        <div class="col-lg-3">
                                            <input type="submit" class="btn-form" id="modal_submit" value="Add Vehicle">
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
let id = "0";
let operation = "add";
let table;
let data;
displayVehicle();
let formValidation = $("#vehicleForm").validate({
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
        type: {
            required: true,
        },
        plate: {
            required: true,
            remote: {
                url: '/school/vehicles/plate_number',
                type: "POST",
                data: {
                    id: function() {
                        return id;
                    },
                    operation: function() {
                        return operation;
                    },
                    data: function() {
                        return $('#plate').val();
                    }
                },

            }
        },
        manufacturer: {
            required: true,
        },
        model: {
            required: true,
        },
        year: {
            required: true,
        },
        transmission: {
            required: true,
        },
        fuel: {
            required: true,
        },
        color: {
            required: true,
        },
        images: {
            required: true,
        },
    },
    messages: {
        name: {
            required: 'Vehicle name is required',
        },
        type: {
            required: 'Vehicle type is required',
        },
        plate: {
            required: 'Plate number is required',
            remote: 'Plate number already used',
        },
        manufacturer: {
            required: 'Manufacturer is required',
        },
        model: {
            required: 'Model is required',
        },
        year: {
            required: 'Year is required',
        },
        transmission: {
            required: 'Transmission is required',
        },
        fuel: {
            required: 'Fuel is required',
        },
        Color: {
            required: 'Color is required',
        },
        images: {
            required: 'Image is required',
        },
    },
    submitHandler: function(form) {
        let url = operation == "add" ?
            '/school/vehicles/store' :
            "/school/vehicles/" + id + "/update";
        console.log(url);
        $.ajax({
            type: "POST",
            url: url,
            processData: false,
            contentType: false,
            data: new FormData(form),
            success: function(response) {
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
                    table.row.add(response.vehicle).draw(false)
                    resetForm();
                    $('#vehicleModalForm').modal('hide');
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

function displayVehicle() {
    $.ajax({
        type: "POST",
        url: "{{ route('retrieve.vehicles') }}",
        data: $(this).serialize(),
        success: function(response) {
            table = $('#table').DataTable({
            
                order: [7, 'desc'],
                data: JSON.parse(response),
                columns: [{
                        data: function(data, type, row) {
                            console.log(data);
                            return `
                                <div class="d-flex align-items-center" style="gap: 10px;padding:5px 0">
                    <img src="/` + data.vehicle_img + `" class="rounded-circle"
                        style="width: 40px;height:40px;object-fit: cover;" alt="Avatar" />
                        <div>
                            <h6>` + data.name + `</h6>
                           
                            </div>
                </div>                             
                                `;
                        }
                    },
                    {
                        data: 'plate_number',

                    },
                    {
                        data: 'manufacturer',
                    },
                    {
                        data: 'model'
                    },
                    {
                        data: 'year'
                    },
                    {
                        data: 'transmission',
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
                        data: 'date_updated',
                        visible: false,
                    },
                    {
                        data: null,
                    },
                ],
                columnDefs: [{
                    data: null,
                    targets: -1,
                    render: function(data) {
                        return `<div class="dropdown">
                                            <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            </i>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="/school/view/${data.id}">More Details</a></li>
                                                <li><a class="dropdown-item update" role="button">Update</a></li>
                                                <li><a class="dropdown-item delete" href="#">Delete</a></li>
                                            </ul>
                                        </div>`;
                    }

                }],
                // dom: 'Bfrtip',
                // buttons: [{
                //         extend: 'copy',
                //         exportOptions: {
                //             columns: ':visible:not(:last-child)'
                //         },
                //         title: 'List of Vehicles'
                //     },
                //     {
                //         extend: 'csv',
                //         exportOptions: {
                //             columns: ':visible:not(:last-child)'
                //         },
                //         title: 'List of Vehicles'
                //     },
                //     {
                //         extend: 'excel',
                //         exportOptions: {
                //             columns: ':visible:not(:last-child)'
                //         },
                //         title: 'List of Vehicles'
                //     },
                //     {
                //         extend: 'pdf',
                //         exportOptions: {
                //             columns: ':visible:not(:last-child)' // Exclude hidden columns
                //         },
                //         title: 'List of Vehicles',
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
                //         title: 'List of Vehicles'
                //     }
                // ],

            });
        }
    });
}
$(document).on('click', '.update', function() {

    resetForm();
    operation = "edit";
    data = $('#table').DataTable().row($(this).parents('tr'));
    const tempData = data.data();
    id = tempData.id;
    $('#modal_title').html('Update Vehicle');
    $('#vehicleModalForm').modal('show');
    $('#modal_submit').val('Update Vehicle');
    $('#name').val(tempData.name);
    $('#type').val(tempData.type);
    $('#plate').val(tempData.plate_number);
    $('#manufacturer').val(tempData.manufacturer);
    $('#model').val(tempData.model);
    $('#year').val(tempData.year);
    $('#transmission').val(tempData.transmission);
    $('#fuel').val(tempData.fuel);
    $('#color').val(tempData.color);


});
$(document).on('click', '#modal_btn', function() {
    operation = "add";
    resetForm();
    $('#modal_title').html('Add New vehicle');
    $('#vehicleModalForm').modal('show');
    $('#modal_submit').val('Add Vehicle');
});

function resetForm() {
    $('.check-label').css('display', 'none');
    $('.error').css('display', 'none');
    $('#vehicleForm').trigger("reset");
}


$(document).on('click', '.delete', function() {
    data = $('#table').DataTable().row($(this).parents('tr'));
    const tempData = data.data();
    id = tempData.id;

    swal({
        title: "Delete Vehicle?",
        text: "Are you sure you want to delete vehicle? ",
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
                url: "{{ route('delete.vehicle') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    vehicle_id: id,
                },
                success: function(response) {
                    if (response.code == 200) {
                        swal({
                            icon: "success",
                            title: 'Vehicle Successfully Deleted',
                            text: " ",
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(function() {
                            window.location.href =
                                "{{ route('index.vehicles') }}";
                        });
                    } else {
                        swal({
                            icon: "error",
                            title: 'The deletion was unsuccessful. The vehicle is already in use',
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
    var type = $("#typeFilter").val();
    var transmission = $('#transmissionFilter').val();
    var fuel = $("#fuelFilter").val();


    if (type == "") {
        swal({
            icon: "error",
            title: 'Select Vehicle Type',
            text: " ",

        });
    } else if (transmission == "") {
        swal({
            icon: "error",
            title: 'Select Transmission',
            text: " ",

        });
    } else if (fuel == "") {
        swal({
            icon: "error",
            title: 'Select Fuel',
            text: " ",
        });
    } else {
        $.ajax({
            url: '{{route("school.filter.vehicles")}}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                type: type,
                transmission: transmission,
                fuel: fuel,
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

{{-- <script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('40178e8c6a9375e09f5c', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('test');
    channel.bind('test-event', function(data) {
        alert(JSON.stringify(data));
    });
</script> --}}
@include(SchoolFileHelper::$footer)