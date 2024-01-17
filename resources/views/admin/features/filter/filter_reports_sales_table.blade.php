<script>
$(document).ready(function() {
    $('#table11').DataTable();
});
</script>

<table id="table11" class="table" style="width:100%">
    <thead>
        <tr>
            <th>Course</th>
            <th>Total Order</th>
            <th>Total Sales</th>
            <th>Balance</th>

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

        </tr>
        @endforeach
    </tbody>

</table>