@include(SchoolFileHelper::$header, ['title' => "Vehicle Report: $vehicle_name"])
<div class="container-fluid" style="padding: 20px;margin-top:60px">
    <div class="row">

        <div class="col-12">
            <div id="filterresult">
                <table id="table" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Instructor</th>
                            <th>Content</th>
                            <th>Date Reported</th>
                            <th style="width: 60px">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
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
    var vehicleId = "<?php echo $vehicle_id; ?>";
    var url = "{{ route('retrieve.vehicle.report', ['id' => ':vehicleId']) }}";
    url = url.replace(':vehicleId', vehicleId);

    $.ajax({
        type: "POST",
        url: url,
        data: $(this).serialize(),
        success: function(response) {
            console.log(response);
            table = $('#table').DataTable({
                order: [2, 'desc'],
                data: response,
                columns: [{
                        data: function(data, type, row) {
                            return `
                                <div class="d-flex align-items-center" style="gap: 10px;padding:5px 0">
                                    <img src="/${data.instructor.profile_image}" class="rounded-circle" style="width: 40px;height:40px;object-fit:cover" alt="Avatar" />
                                    <div>
                                        <h6>${data.instructor.firstname} ${data.instructor.middlename ?? ""} ${data.instructor.lastname}</h6>
                                        <p style="font-size:14px" class="email">${data.instructor.email}</p>
                                    </div>
                                </div>`;
                        }
                    },
                    {
                        data: 'content',
                    },
                    {
                        data: 'date_created',
                        render: function(data, type, row) {
                            return moment(data).format(
                                'MMM D, YYYY - hh:mm A');

                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `<div class="dropdown">
                                            <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                               
                                            </i>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="/school/vehicle/schedulesreport/${data.id}/view">More Details</a></li>
                                                <li><a class="dropdown-item" onclick="scheduleDetails(${data.schedule_id});" role="button">Shedule Details</a></li>
                                            </ul>
                                        </div>`;
                        }
                    },
                ],
            });
        }
    });

    function scheduleDetails(id) {
        $('#scheduleView').modal('show');
        $('#body').html(`<center><h5>Loading...</h5></center>`);
        $.ajax({
            method: 'POST',
            url: "{{ route('view.sched.vehicle') }}",
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