@include(SchoolFileHelper::$header, ['title' => 'Order Details'])
<style>
    .btn-view {
        background-color: var(--secondaryBG);
        color: white;
        padding: 8px 20px;
        border-radius: 5px;
        border: none;
        outline: none;
        font-size: 15px;
    }

    .btn-link,
    .btn-link:hover {
        background-color: var(--secondaryBG);
        color: white;
        padding: 9px 20px;
        border-radius: 5px;
        border: none;
        outline: none;
        font-size: 15px;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-outline {
        background-color: white;
        color: var(--secondaryBG);
        padding: 8px 20px;
        font-size: 15px;
        border-radius: 5px;
        border: 1px solid var(--secondaryBG);
        outline: none;
    }

    #btn-form {
        background-color: var(--primaryBG);
        color: white;
        padding: 8px 20px;
        border-radius: 5px;
        border: none;
        font-size: 15px;
        width: 100%;
        outline: none;
    }

    .btn-text {
        color: var(--secondaryBG);
    }

    .btn-text:hover {
        color: var(--secondaryBG);
    }

    .prompt {
        background-color: #6CC070;
        width: 100%;
        padding: 15px 20px;

        color: #fff;
    }
</style>
<div class="container-fluid" style="margin:60px 0 0 0;padding:0">
    <div class="" style="padding:20px">
        <div class="d-flex align-items-center justify-content-between" style="margin-bottom: 20px">
            <div>
                <h5 style="margin-bottom:5px">Order id: {{ $order->id }}</h5>
                <h6 class="d-flex align-items-center justify-content-start" style="gap: 10px">
                    Status:
                    @switch($order->status)
                        @case(1)
                            Pending Order
                        @break

                        @case(2)
                            To pay
                        @break

                        @case(3)
                            Waiting for requirements
                        @break

                        @case(4)
                            Courses Ongoing
                        @break

                        @case(5)
                            Order Completed
                        @break

                        @case(6)
                            Cancelled
                        @break

                        @case(7)
                            Refunded
                        @break

                        @default
                    @endswitch
                </h6>
            </div>
            <div class="dropdown">
                <i class="fa-sharp fa-solid fa-gear" style="font-size: 20px" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false"></i>
                <ul class="dropdown-menu">
                    {{-- <li><a class="dropdown-item" href="#">Add addtional payment</a></li> --}}
                    @if (in_array($order->status, [3, 4]))
                        <li><a class="dropdown-item" role="button" data-bs-toggle="modal"
                                data-bs-target="#refundORder">Refund order</a></li>
                    @endif
                    <li><a class="dropdown-item"
                            href="{{ route('logs.order', [
                                'id' => $order->id,
                            ]) }}">Order
                            logs</a></li>
                </ul>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between" style="margin: 10px 0;column-gap:10px">
            <div class="d-flex align-items-center" style="column-gap:10px">
                <img src="/{{ $order->profile_image }}" alt=""
                    style="width: 40px;height:40px;object-fit:cover;border-radius:50%">
                <div>
                    <h6 style="font-weight: 500">
                        {{ $order->firstname }} {{ $order->lastname }}
                    </h6>
                    <p style="font-size: 14px;font-weight:500">
                        {{ $order->email }}
                    </p>
                </div>
            </div>
            <i class="far fa-comments-alt" onclick="messageWithUser('{{ $order->student_id }}');"
                style="font-size: 20px"></i>
        </div>
        <h6 style="margin-top: 20px">Items: ({{ count($items) }})</h6>
        @foreach ($items as $item)
            <div class="d-flex align-items-center justify-content-between course-order-view">
                <div style="column-gap:10px;margin-top:20px" class="d-flex align-items-center">
                    <img src="/{{ $item->thumbnail }}" alt=""
                        style="width: 70px;height:70px;object-fit:cover;border-radius:10px">
                    <div>
                        <h6>Course name: {{ $item->name }}</h6>
                        <h6>Course price: {{ number_format($item->price, 2) }}</h6>
                        <h6>Status: @switch($item->status)
                                @case(1)
                                    Waiting For Session
                                @break

                                @case(2)
                                    Course Ongoing
                                @break

                                @case(3)
                                    Course Completed
                                @break

                                @case(4)
                                    Void
                                @break

                                @default
                            @endswitch
                        </h6>
                    </div>
                </div>
                @if (in_array($order->status, [4, 5]))
                    <a href="{{ route('view.availedcourse', ['id' => $item->id]) }}" class="btn-text">View
                        availed
                        course</a>
                @endif
            </div>
        @endforeach
        @if ($order->status != 6)
            <div class="d-flex align-items-center justify-content-between bottom-order" style="margin-top: 20px">
                <div>
                    <h5 style="margin-bottom: 10px">Total Price: {{ number_format($order->total_amount, 2) }}</h5>
                    @if ($order->status == 7)
                        <h6>
                            Refunded Amount:
                            @if ($order->payment_type == 1)
                                {{ number_format($order->total_amount - ($order->total_amount - $total_cash_payment), 2) }}
                                Php
                            @else
                                {{ number_format($order->total_amount, 2) }} Php
                            @endif
                        </h6>
                    @else
                        @if ($order->payment_type == 1 && $order->status != 1)
                            @if ($total_cash_payment != $order->total_amount)
                                <h6>Remaining balance:
                                    {{ number_format($order->total_amount - $total_cash_payment, 2) }}
                                </h6>
                            @else
                                <h6>Payment Already Completed</h6>
                            @endif
                        @endif
                    @endif

                    <h6 style="margin:0 0 5px 0">Payment type: @switch($order->payment_type)
                            @case(1)
                                Cash
                            @break

                            @case(2)
                                Gcash
                            @break

                            @case(3)
                                Credit Card
                            @break

                            @default
                        @endswitch

                        @if ($checkout_status != null)
                            |
                            @switch($checkout_status->status)
                                @case(1)
                                    Waiting for payment
                                @break

                                @case(2)
                                    Paid
                                @break

                                @case(3)
                                @break

                                @default
                            @endswitch
                        @endif
                    </h6>
                </div>
                <div class="d-flex align-items-center" style="column-gap: 10px">
                    @if ($order->status == 2 || $order->status == 1)
                        <button class="btn-outline" data-bs-toggle="modal" data-bs-target="#cancelOrder">Cancel
                            Order</button>
                    @endif
                    @if ($order->status == 1)
                        <a class="btn-link"
                            href="{{ route('accept.order', [
                                'id' => $order->id,
                            ]) }}">Accept
                            order</a>
                    @endif
                    @if ($order->status == 3)
                        <button class="btn-outline"
                            onclick="r= confirm('Are you sure you want to accept the requirements ?');if(r==true){location.href='/school/orders/{{ $order->id }}/view/acceptRequirements';}">Accept
                            Requirements</button>
                    @endif
                    @if (!in_array($order->status, [1, 6, 7]))
                        @if ($order->payment_type == 1 && $total_cash_payment != $order->total_amount)
                            <button class="btn-view" data-bs-toggle="modal" data-bs-target="#makePaymentModal">Make a
                                payment</button>
                        @endif
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@if ($order->payment_type == 1)
    <div class="modal fade" id="makePaymentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="d-flex align-items-center justify-content-between" style="padding: 25px 25px 0 25px">
                    <h5 class="" id="">Make a payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="payment-form"
                        action="{{ route('create.cashpayment', [
                            'order_id' => $order->id,
                        ]) }}"
                        style="padding: 0 10px 10px 10px" id="formPayment">
                        @csrf
                        <div class="card" style="margin-bottom: 10px;">
                            @if ($order->payment_type == 1 && $total_cash_payment != $order->total_amount)
                                <h6>Remaining balance:
                                    {{ number_format($order->total_amount - $total_cash_payment, 2) }}
                                </h6>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Amount to be paid:</label>
                            <input type="number" required class="form-control"
                                value="{{ $order->total_amount - $total_cash_payment }}"
                                max="{{ number_format($order->total_amount - $total_cash_payment, 2) }}" id="amount"
                                name="amount">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Cash tender:</label>
                            <input type="number" class="form-control" id="cash" name="cash" required>
                        </div>
                        <button id="btn-form">Create payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="modal fade" id="refundORder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="d-flex align-items-center justify-content-between" style="padding: 25px 25px 0 25px">
                <h5 class="" id="">Refund Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST"
                    action="
                {{ route('refund.order', [
                    'id' => $order->id,
                ]) }}"
                    id="refund-form" style="padding: 0 10px 10px 10px" id="formCancel">
                    @csrf
                    <h6 style="margin-bottom: 10px">Amount that will be funded:</h6>
                    <h5 style="margin-bottom: 20px">
                        @if ($order->payment_type == 1)
                            {{ number_format($order->total_amount - ($order->total_amount - $total_cash_payment), 2) }}
                            Php
                        @else
                            {{ number_format($order->total_amount, 2) }} Php
                        @endif
                    </h5>
                    <div class="mb-3">
                        <label for="" class="form-label">Reason:</label>
                        <input type="text" class="form-control" id="reason" name="content" required>
                    </div>
                    <button id="btn-form" class="">Refund</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="cancelOrder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="d-flex align-items-center justify-content-between" style="padding: 25px 25px 0 25px">
                <h5 class="" id="">Cancel Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST"
                    action="
                {{ route('cancel.order', [
                    'id' => $order->id,
                ]) }}"
                    id="payment-form" style="padding: 0 10px 10px 10px" id="formCancel">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Reason:</label>
                        <input type="text" class="form-control" id="reason" name="content" required>
                    </div>
                    <button id="btn-form" class="">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

@if (session('order_message'))
    <script>
        Toastify({
            text: "{{ session('order_message') }}",
            duration: 2000,

            gravity: "top", // `top` or `bottom`
            position: "center", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: "forestgreen",
            },
            onClick: function() {} // Callback after click
        }).showToast();
    </script>
@endif

<script>
    $(document).ready(function() {
        let cash = $('#cash').val();
        let amount = $('#amount').val();
        $("#payment-form").validate({

            rules: {
                amount: {
                    required: true,
                    max: {{ $order->total_amount - $total_cash_payment }},
                    min: 1,
                    number: true
                },
                cash: {
                    required: true,
                    number: true

                },
            },
            messages: {
                amount: {
                    required: "Amount is required",

                },
                cash: {
                    required: "Cash tendered is required",

                }
            },
            submitHandler: function(form) {
                let cash = parseFloat($('#cash').val());
                let amount = parseFloat($('#amount').val());
                if (amount > cash) {
                    alert("invalid cash tendered value");
                    return;
                }
                form.submit();
            }
        });


    });
</script>
@include(SchoolFileHelper::$footer)
