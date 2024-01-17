@include(SchoolFileHelper::$header, ['title' => 'Student Management'])
<div class="container-fluid" style="padding: 20px;margin-top:60px">
    <div class="row">
        <div class="col-12">
            <div class="w-100 d-flex align-items-center justify-content-between table-header-btn">
                <div class="d-flex" style="gap:15px">
                    <a class="btn-outline-light" href="{{route('student.export.pdf')}}"><i
                            class="fa-solid fa-file-export"></i>Export
                        PDF</a>
                    <!-- <button class="btn-outline-light"><i class="fa-solid fa-file-export"></i>Import CSV</button> -->
                </div>
                <a href="{{ route('create.student') }}">
                    <button class="btn-add-management" id="modal_btn"><i class="fa-solid fa-plus"></i> Add new
                        student</button>
                </a>
            </div>
            <table id="table" class="table" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Sex</th>
                        <th>Birthdate</th>
                        <th>Address</th>
                        <th>Mobile Number</th>
                        <th>Date Created</th>
                        <th width="50">Action</th>
                    </tr>
                </thead>
            </table>
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
let table;
displayStudent();

function displayStudent() {
    $.ajax({
        type: "POST",
        url: "{{ route('retrieve.student') }}",
        data: $(this).serialize(),
        success: function(response) {
            table = $('#table').DataTable({
                "scrollX": true,
                order: [5, 'desc'],
                data: JSON.parse(response),
                columns: [{
                        data: function(data, type, row) {
                            console.log(data);
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
                        data: 'sex',
                    },
                    {
                        data: 'birthdate',
                    },
                    {
                        data: 'address',
                    },
                    {
                        data: 'phone_number',
                    },
                    {
                        data: 'date_created',
                        visible: false,
                    },
                    {
                        data: function(data, type, row) {
                            return `<div class="dropdown">
                                            <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            </i>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item view-progress" href="/school/student/${data.student_id}/profile">Student Profile</a></li>
                                                <li><a class="dropdown-item" href="/school/student/${data.student_id}/makeorder" role="button">Make an order</a></li>
                                                <li><a class="dropdown-item" href="#">Delete</a></li>
                                            </ul>
                                        </div>`;
                        }
                    },
                ],


            });
        }
    });
}
</script>
@include(SchoolFileHelper::$footer)