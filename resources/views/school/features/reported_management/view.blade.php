@include(SchoolFileHelper::$header, ['title' => 'Report Details'])

<div class="container-fluid" style="padding: 20px;margin-top:60px">
    <div class="row">

        <div class="col-lg-6">
            <h6>Student:</h6>
            <div class="d-flex align-items-center justify-content-between" style="margin: 10px 0;column-gap:10px">
                <div class="d-flex align-items-center" style="column-gap:10px">
                    <img src="/{{ $report->student->profile_image }}" alt=""
                        style="width: 40px;height:40px;object-fit:cover;border-radius:50%">
                    <div>
                        <h6 style="font-weight: 500">
                            {{ $report->student->firstname }} {{ $report->student->lastname }}
                        </h6>
                        <p style="font-size: 14px;font-weight:500">
                            {{ $report->student->email }}
                        </p>
                    </div>
                </div>
                {{-- <i class="far fa-comments-alt" onclick="messageWithUser('{{ $report->student->student_id }}');"
                    style="font-size: 20px"></i> --}}
            </div>
        </div>
        <div class="col-lg-6">
            <h6>Reported Instructor:</h6>
            <div class="d-flex align-items-center justify-content-between" style="margin: 10px 0;column-gap:10px">
                <div class="d-flex align-items-center" style="column-gap:10px">
                    <img src="/{{ $report->instructor->profile_image }}" alt=""
                        style="width: 40px;height:40px;object-fit:cover;border-radius:50%">
                    <div>
                        <h6 style="font-weight: 500">
                            {{ $report->instructor->firstname }} {{ $report->instructor->lastname }}
                        </h6>
                        <p style="font-size: 14px;font-weight:500">
                            {{ $report->instructor->email }}
                        </p>
                    </div>
                </div>
                {{-- <i class="far fa-comments-alt" onclick="messageWithUser('{{ $report->instructor->user_id }}');"
                    style="font-size: 20px"></i> --}}
            </div>
        </div>
        <div class="col-12">
            <h6 style="margin: 20px 0">Date Reported: {{ $report->date_created }}</h6>
        </div>
        <div class="col-12">
            <div>
                <h6 style="">Content:</h6>

            </div>
            <div class="card" style="margin-top: 15px">
                <h6>
                    {{ $report->comments }}
                </h6>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade modal-lg" id="scheduleView" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" id="exampleModalLabel">Schedule Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="" style="padding: 20px 7px" id="body">

            </div>
        </div>
    </div>
</div>
<script>
    function scheduleDetails(id) {
        $('#scheduleView').modal('show');
        $('#body').html(`<center><h5>Loading...</h5></center>`);
        $.ajax({
            method: 'POST',
            url: "{{ route('view.sched') }}",
            data: {
                'id': id,
            },
            success: function(response) {
                console.log(response);
                $('#body').html(response);
            }
        });
    }
</script>



@include(SchoolFileHelper::$footer)
