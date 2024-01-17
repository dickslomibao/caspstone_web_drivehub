@include(SchoolFileHelper::$header, ['title' => 'Course details'])


@php
    $currentYear = date('Y');
    $currentMonth = date('F');
    $lastMonth = date('F', strtotime('-1 month'));

    $total = 0;
    foreach ($coursesData as $courses) {
        $total += $courses;
    }

@endphp

<div class="container-fluid" style="margin-top:60px;padding:20px;">
    <div class="row">
        @if (session('course_message'))
            <h5 style="color: forestgreen;margin-bottom:20px">Added Successfully</h5>
        @endif
        <div class="col-12">
            <div class="card">

                <div class="d-flex align-items-center justify-content-start" style="column-gap:10px;">
                    <img src="/{{ $course->thumbnail }}" alt="" height="80" width="80"
                        style="object-fit: cover;border-radius:5px" srcset="">
                    <div>
                        <h6>Course
                            name: {{ $course->name }}</h6>
                        <h6 style="margin-top:5px;">Status: @switch($course->status)
                                @case(1)
                                    Available
                                @break

                                @case(2)
                                    Not available
                                @break

                                @default
                            @endswitch
                        </h6>
                        <h6 style="margin-top:5px;">Status: @switch($course->visibility)
                                @case(1)
                                    Visible on public
                                @break

                                @case(2)
                                    Hidden on public
                                @break

                                @default
                            @endswitch
                        </h6>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="w-100 d-flex justify-content-between table-header-btn">
                <div>

                </div>
                @if ($course->type == 1)
                    <button class="btn-add-management" data-bs-toggle="modal" data-bs-target="#add_new_variant"><i
                            class="fa-solid
                fa-plus"></i> Add new Variant</button>
                @endif
            </div>
            <table id="table" class="table" style="width:100%">
                <thead>
                    <tr>
                        <th>Duration</th>
                        <th width="120">Price</th>
                        <th width="120">Status</th>
                        <th>Date Created</th>
                        <th width="50">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
  
    <div class="col-12 mx-auto mt-3 mb-3">
        <div class="card rounded">
            <center>
                <h5 id="title"><b>Total Course Orders Made in <span id="taon">{{ $currentYear }} </span>:
                        {{ $total }}
                        Orders</b>
                </h5>
            </center>

            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-sm-5"> <label for="">Filter Year</label>

                            <input type="hidden" name="courseID" id="courseID" value="{{ $courseID }}"
                                class="form-control mb-3" max="4" required>
                            <input type="number" name="year" id="year" value="{{ $currentYear }}"
                                class="form-control mb-3" max="4" required>
                        </div>
                        <div class="col-sm-3"><label for=""></label>
                            <br>
                            <button type="submit" id="filterbutton" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </div>
            </div>


            <div id="filterresult">
                <center>
                    <canvas id="coursesChart" style="width:100%;"></canvas>
                </center>
            </div>

        </div>
    </div>





</div>
<div class="modal fade" id="add_new_variant" tabindex="-1" aria-labelledby="add_new_variantLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form method="post" style="padding: 0 10px 10px 10px" action="">
                    @csrf
                    <h5 style="margin-bottom: 20px">Add new variant</h5>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Duration:</label>
                                <input type="number" name="duration" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Price:</label>
                                <input type="number" name="price" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div style="padding: 0 0 0px  0">
                        <div class="row justify-content-end">
                            <div class="col-12">
                                <input type="submit" class="btn-form" value="Create"
                                    style="font-size: 15px !important">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<!-- Modal for update -->

<div class="modal fade" id="update_variant" tabindex="-1" aria-labelledby="add_new_variantLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form method="post" id="updateVariant" style="padding: 0 10px 10px 10px" action="">
                    @csrf
                    <h5 style="margin-bottom: 20px">Update Variant</h5>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Duration:</label>
                                <input type="number" id="duration1" name="duration1" class="form-control" required>
                                <input type="hidden" id="variant_id" name="variant_id" class="form-control"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Price:</label>
                                <input type="number" id="price1" name="price1" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div style="padding: 0 0 0px  0">
                        <div class="row justify-content-end">
                            <div class="col-12">
                                <input type="submit" class="btn-form" value="Update"
                                    style="font-size: 15px !important">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        $('#filterbutton').click(function() {

            var year = $('#year').val();
            var courseID = $('#courseID').val();
            // $('#taon').text(year);

            $.ajax({
                url: '{{ route('school.course.filter.graph') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    year: year,
                    courseID: courseID,
                },
                success: function(response) {
                    $('#filterresult').html(response);
                    $('#title').hide();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log("Error Thrown: " + errorThrown);
                    console.log("Text Status: " + textStatus);
                    console.log("XMLHttpRequest: " + XMLHttpRequest);
                    console.warn(XMLHttpRequest.responseText)
                }
            });


        });
    });
</script>


<script>
    let table = $('#table').DataTable({
        order: [2, 'desc'],
        data: JSON.parse(`<?php echo json_encode($variants); ?>`),
        columns: [{
                data: null,
                render: function(data, type, row) {
                    return `${data['duration']} hrs`;
                }
            },
            {
                data: null,
                render: function(data, type, row) {
                    return `Php ${data['price'].toFixed(2)}`;
                }
            },
            {
                data: null,
                render: function(data, type, row) {
                    return data['status'] == 1 ?
                        '<span class="available">&#8226 Available</span>' :
                        '<span class="not-available">&#8226 Not available</span>';
                }
            },
            {
                data: 'date_created',
                visible: false,
            },
            {
                data: null,
                render: function(data, type, row) {
                    return `<div class="dropdown">
                                            <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            </i>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="">View course</a></li>
                                                <li><a class="dropdown-item update" role="button">Update</a></li>
                                                <li><a class="dropdown-item" href="#">Delete</a></li>
                                            </ul>
                                        </div>`;
                }
            },
        ],


    });



    $(document).on('click', '.update', function() {
        data = $('#table').DataTable().row($(this).parents('tr'));
        const tempData = data.data();
        id = tempData.id;
        $('#update_variant').modal('show');
        $('#duration1').val(tempData.duration);
        $('#price1').val(tempData.price);
        $('#variant_id').val(tempData.id);

    });


    $("#updateVariant").submit(function(e) {
        e.preventDefault(); // Prevent the form from submitting in the traditional way

        $.ajax({
            type: "POST",
            url: "{{ route('update.variant') }}",
            contentType: false,
            processData: false,
            data: new FormData(this),
            success: function(response) {
                swal({
                    icon: "success",
                    title: 'Sub Progress Successfully Updated',
                    text: " ",
                    timer: 2000,
                    showConfirmButton: false,
                }).then(function() {
                    $('#update_variant').modal('hide');
                    location.reload(true);
                });
            },
            error: function(xhr, status, error) {
                console.log("AJAX Error: " + error);
            }
        });
    });


    function resetForm() {

        $('#updateVariant').trigger("reset");
    }



    var course = <?php echo json_encode($coursesData); ?>;
    var xValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    new Chart("coursesChart", {
        type: "line",
        data: {
            labels: xValues,
            datasets: [{
                label: "No. of Orders",
                data: course,
                borderColor: "rgba(84, 94, 225)",
                backgroundColor: "rgba(0, 0, 255, 0.3)",
                fill: true
            }]
        },
        options: {
            legend: {
                display: true,
                position: 'bottom'
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>



@include(SchoolFileHelper::$footer)
