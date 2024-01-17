<script>
    $(document).ready(function() {
        $('#table1').DataTable();
    });
</script>



<div class="w-100 d-flex justify-content-between table-header-btn">
    <div class="d-flex" style="gap:15px">
        <a class="btn-outline-light" href="/school/ordersPayment/{{$status}}/{{$payment}}/{{$start_date}}/{{$end_date}}/export_pdf"><i class="fa-solid fa-file-export"></i>Export
            PDF</a>
    </div>
    <button class="btn-add-management" id="modal_btn"><i class="fa-solid fa-plus"></i> Add new
        Orders</button>
</div>

<table id="table1" class="table1" style="width:100%">
    <thead>
        <tr>
            <th>Student Name</th>
            <th>Total Amount</th>
            <th>Payment Method</th>
            <th>Status</th>
            <th>Date Ordered</th>
            <th width="50">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
        @php


        if ($order->payment_type == 1) {
        $payment = 'Cash';

        $balance = $order->total_amount - $order->total_paid;
        if ($balance == 0) {
        $payment = 'Cash<br>Payment Completed';
        } else {
        $payment = 'Cash<br>Balance: ' . number_format($balance, 2);
        }
        } elseif ($order->payment_type == 2) {
        $payment = 'GCash';
        } else {
        $payment = 'Credit Card';
        }




        if($order-> status == 1){
        $statusString = 'Pending Orders';
        }else if($order-> status == 2){
        $statusString = 'To Pay';
        }else if($order-> status == 3){
        $statusString = 'Waiting for requirements';
        }else if($order-> status == 4){
        $statusString = 'Courses Ongoing';
        }else if($order-> status == 5){
        $statusString = 'Order Completed';
        }else if($order-> status == 6){
        $statusString = 'Cancelled';
        }

        @endphp


        <tr>
            <td>

                <div class="d-flex align-items-center" style="gap: 10px;padding:5px 0">
                    <img src="/{{$order -> profile_image}}" class="rounded-circle" style="width: 40px;height:40px" alt="Avatar" />
                    <div>
                        <h6>{{$order -> firstname}} {{$order -> middlename ?? ""}} {{$order -> lastname}}</h6>
                        <p style="font-size:14px" class="email"> {{$order -> email}}</p>
                    </div>
                </div>

            </td>
            <td>{{ number_format( $order->total_amount, 2) }}</td>
            <td>{!! $payment !!}</td>
            <td>{{ $statusString}}</td>
            <td>{{ \Carbon\Carbon::parse($order->date_created)->format('F j, Y - h:i:s A') }}</td>
            <td>
                <div class="dropdown">
                    <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown" aria-expanded="false"></i>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/school/orders/{{$order->id}}/view">View Order</a></li>
                    </ul>
                </div>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>