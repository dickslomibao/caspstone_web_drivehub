@include(SchoolFileHelper::$header, ['title' => 'Student Progress'])

<div class="container-fluid" style="padding: 20px;margin-top:60px">
    <div class="row">
        <div class="col-12">
            <div class="row">
                @foreach ($mock_list as $m)
                    <div class="col-lg-6">
                        <div class="card">
                            <h6 style="line-height: 21px">Mock Exam: {{ $m->mock_count }}</h6>
                            <h6 style="line-height: 21px">Items: {{ $m->items }}</h6>
                            <h6 style="line-height: 21px">Date Assigned: {{ $m->date_created }}</h6>
                            <h6 style="line-height: 21px">Status: @switch($m->status)
                                    @case(1)
                                        Waiting to take
                                    @break

                                    @case(2)
                                        Started
                                    @break

                                    @case(3)
                                        Completed
                                    @break

                                    @default
                                @endswitch
                            </h6>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@include(SchoolFileHelper::$footer)
