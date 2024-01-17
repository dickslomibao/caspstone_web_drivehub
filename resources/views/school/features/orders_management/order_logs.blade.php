@include(SchoolFileHelper::$header, ['title' => 'Order logs'])

<div class="container-fluid" style="margin:60px 0 0 0;padding:0">
    <div class="" style="padding:20px">
        @if ($order->payment_type == 1)
            <h6 style="margin-bottom: 20px">Payment</h6>

            @forelse ($payment_logs as $p)
                <div class="card" style="margin-top: 10px">
                    <div class="row">
                        <div class="col-12">
                            <h6>Amount: {{ number_format($p->amount, 2) }} Php</h6>
                            <h6>Date Process: {{ $p->date_created }}</h6>
                            @php
                                $staff = $staffRepository->getSingleSchoolStaffWithId($p->process_by);
                            @endphp
                            <h6>Process By: @if ($staff == null)
                                    Admin
                                @else
                                    {{ $staff->firstname }} {{ $staff->lastname }}
                                @endif
                            </h6>
                        </div>
                    </div>
                </div>
            @empty
                <h6>No process payment</h6>
            @endforelse
        @endif

        @if ($order->status == 6)
            <h6 style="margin: 20px 0">Cancelled</h6>
            @foreach ($reasons as $c)
                @if ($c->type == 1)
                    <div class="card" style="margin-top: 10px">
                        <div class="row">
                            <div class="col-12">
                                <h6>Reasons:{{ $c->content }}</h6>
                                <h6>Date Process: {{ $c->date_created }}</h6>
                                @php
                                    $staff = $staffRepository->getSingleSchoolStaffWithId($c->process_by);
                                @endphp
                                <h6>Process By: @if ($staff == null)
                                        Admin
                                    @else
                                        {{ $staff->firstname }} {{ $staff->lastname }}
                                    @endif
                                </h6>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
        @if ($order->status == 7)
            <h6 style="margin: 20px 0">Refunded</h6>

            @foreach ($reasons as $r)
                @if ($r->type == 2)
                    <div class="card" style="margin-top: 10px">
                        <div class="row">
                            <div class="col-12">
                                <h6>Reasons:{{ $r->content }}</h6>
                                <h6>
                                    Refunded Amount:
                                    @if ($order->payment_type == 1)
                                        {{ number_format($order->total_amount - ($order->total_amount - $total_cash_payment), 2) }}
                                        Php
                                    @else
                                        {{ number_format($order->total_amount, 2) }} Php
                                    @endif
                                </h6>
                                <h6>Date Process: {{ $r->date_created }}</h6>
                                @php
                                    $staff = $staffRepository->getSingleSchoolStaffWithId($r->process_by);
                                @endphp
                                <h6>Process By: @if ($staff == null)
                                        Admin
                                    @else
                                        {{ $staff->firstname }} {{ $staff->lastname }}
                                    @endif
                                </h6>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>

@include(SchoolFileHelper::$footer)
