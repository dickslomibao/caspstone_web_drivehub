<script>
    $(document).ready(function() {
        $('#table10').DataTable();
    });
</script>
<div class="w-100 d-flex justify-content-between table-header-btn">
    <div class="d-flex" style="gap:15px">
        <a class="btn-outline-light" href="/school/reports/course/filterTotalSales/{{$start_date}}/{{$end_date}}/export_pdf"><i class="fa-solid fa-file-export"></i>Export
            PDF</a>
    </div>

</div>
<table id="table10" class="table" style="width:100%">
    <thead>
        <tr>
            <th>Course</th>
            <th>Total Order</th>
            <th>Total Sales</th>
            <th>Balance</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ( $sales as $sale)
        @php $balance = $sale -> total_sales - $sale ->total_cash_payments; @endphp

        <tr>
            <td>{{$sale -> name}}</td>
            <td>{{$sale -> availed_service_count}}</td>
            <td>{{number_format($sale -> total_sales, 2)}}</td>
            <td>{{number_format($balance, 2)}}</td>
            <td>
                <div class="dropdown">
                    <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    </i>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item view-progress" href="/school/reports/course/Sales/viewStudents/{{$sale->id}}/{{$sale->name}}/{{$start_date}}/{{$end_date}}">View
                                Students</a></li>

                    </ul>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>