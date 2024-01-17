@include(SchoolFileHelper::$header, ['title' => 'Calendar'])

<style>
    .button-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center
    }

    button {
        background-color: var(--secondaryBG);
        border: none;
        color: #fff;
        width: 200px;
        padding: 0 20px;
        height: 40px;
        font-size: 15px;
        border-radius: 5px;
    }
</style>

<div class="container-fluid" style="padding: 25px;margin-top:60px">
    <div class="row">
        <div class="col-12">
            <div id="calendar"></div>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade modal-lg" id="scheduleView" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    console.log(`<?php echo json_encode($schedules); ?>`);
    $(document).ready(function() {
        $('#calendar').fullCalendar({
            // Configuration options go here
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: JSON.parse(`<?php echo json_encode($schedules); ?>`),
            eventClick: function(event) {
                $('#scheduleView').modal('show');
                $('#body').html(`<center><h5>Loading...</h5></center>`);
                $.ajax({
                    method:'POST',
                    url: "{{ route('view.sched') }}",
                    data: {
                        'id': event.id
                    },
                    success: function(response) {
                        console.log(response);
                        $('#body').html(response);
                    }
                });
            }
            // More options...
        });
    });
</script>
@include(SchoolFileHelper::$footer)
