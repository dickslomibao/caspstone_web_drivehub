<script>
    $(document).ready(function() {
        $('#table1').DataTable();
    });
</script>



<div class="w-100 d-flex justify-content-between table-header-btn">
    <div class="d-flex" style="gap:15px">
        <a class="btn-outline-light" href="/school/vehicles/{{$type}}/{{$transmission}}/{{$fuel}}/export_pdf"><i class="fa-solid fa-file-export"></i>Export
            PDF</a>
    </div>
    <button class="btn-add-management" id="modal_btn"><i class="fa-solid fa-plus"></i> Add new
        vehicle</button>

</div>

<table id="table1" class="table1" style="width:100%">
    <thead>
        <tr>
            <th>Name</th>
            <th>Plate Number</th>
            <th>Manufacturer</th>
            <th>Model</th>
            <th>Year</th>
            <th>Transmission</th>
            <th>Status</th>
            <th width="50">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($vehicles as $vehicle)

        @php
        $statusClass = '';

        if ($vehicle ->status == 1) {
        $status = '&#8226 Available';
        $statusClass = 'available';
        } else {
        $status = '&#8226 Not Available';
        $statusClass = 'not-available';
        }
        @endphp
        <tr>
            <td>
                <div class="d-flex align-items-center" style="gap: 10px;padding:5px 0">
                    <img src="/` + data.vehicle_img + `" class="rounded-circle" style="width: 40px;height:40px;object-fit: cover;" alt="Avatar" />
                    <div>
                        <h6> {{$vehicle -> name}}</h6>
                        <p>{{$vehicle -> type}}</p>
                    </div>
                </div>
            </td>
            <td>{{$vehicle -> plate_number}}</td>
            <td>{{$vehicle -> manufacturer}}</td>
            <td>{{$vehicle -> model}}</td>
            <td>{{$vehicle -> year}}</td>
            <td>{{$vehicle -> transmission}}</td>
            <td><span class="{{ $statusClass }}">{!! $status !!}</span></td>
            <td>
                <div class="dropdown">
                    <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    </i>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">More Details</a></li>
                        <li><a class="dropdown-item update" role="button">Update</a></li>
                        <li><a class="dropdown-item delete" href="#">Delete</a></li>
                    </ul>
                </div>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>