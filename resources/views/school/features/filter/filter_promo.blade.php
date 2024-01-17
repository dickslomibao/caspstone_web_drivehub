<script>
$(document).ready(function() {
    $('#table1').DataTable();
});
</script>



<div class="w-100 d-flex justify-content-between table-header-btn">
    <div class="d-flex" style="gap:15px">
        <a class="btn-outline-light" href="/school/promo/{{$start_date}}/{{$end_date}}/export_pdf"><i
                class="fa-solid fa-file-export"></i>Export
            PDF</a>
    </div>
    <a href="{{ route('create.promo') }}" class="btn-add-management">
        <button id="modal_btn" class="btn-add-management">
            <i class="fa-solid fa-plus"></i> Add new promo
        </button>
    </a>

</div>

<table id="table1" class="table1" style="width:100%">
    <thead>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Description</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th width="50">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ( $promos as $promo)
        <tr>
            <td>{{$promo -> name}}</td>
            <td>
                Php. {{number_format($promo-> price) }}
            </td>
            <td>{{$promo -> description}}</td>

            <td>{{ \Carbon\Carbon::parse($promo->start_date)->format('F j, Y | h:i:s A') }}</td>
            <td>{{ \Carbon\Carbon::parse($promo->end_date)->format('F j, Y | h:i:s A') }}</td>
            <td>
                <div class="dropdown">
                    <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">

                    </i>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/school/promo/{{$promo ->id}}/view">More Details</a></li>
                        <li><a class="dropdown-item update" role="button"
                                href="/school/promo/{{$promo ->id}}/updateView">Update</a></li>
                        <li><a class="dropdown-item delete" href="#">Delete</a></li>
                    </ul>
                </div>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>