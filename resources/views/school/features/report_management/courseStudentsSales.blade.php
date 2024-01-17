<?php if ($start_date == $end_date) {
    $date = new DateTime($start_date);
    $formattedDate = $date->format('F j, Y');
    $dateString = " From " . $formattedDate;
} else {
    $firstdate = new DateTime($start_date);
    $secdate = new DateTime($end_date);
    $formattedDate1 = $firstdate->format('M d, Y');
    $formattedDate2 = $secdate->format('M d, Y');
    $dateString = " From " . $formattedDate1 . " To " . $formattedDate2;
}

?>



@include(SchoolFileHelper::$header, ['title' => 'List of Students Who Ordered \''. $course_name . '\''. $dateString])

<script>
    $(document).ready(function() {
        $('#table').DataTable();
    });
</script>


<div class="container-fluid" style="padding: 20px;margin-top:60px">


    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-sm-7">
                </div>

                <div class="col-sm-4"> <label for="">Duration</label>
                    <select id="duration" class='form-select mb-3' name="duration" required>
                        @foreach ($variants as $variant)


                        <option value="{{$variant->duration}}">{{$variant->duration}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" value="{{$start_date}}" name="start_date" id="start_date">
                    <input type="hidden" value="{{$end_date}}" name="end_date" id="end_date">
                    <input type="hidden" value="{{$course_id}}" name="course_id" id="course_id">
                    <input type="hidden" value="{{$course_name}}" name="course_name" id="course_name">
                </div>
                <div class="col-1">
                    <center><br><button type="submit" id="filterbutton" class="btn btn-primary">Filter</button></center>
                </div>
            </div>
            <div id="filterresult">
                <div class="w-100 d-flex justify-content-between table-header-btn">
                    <div class="d-flex" style="gap:15px">
                        <a class="btn-outline-light" href="/school/reports/course/Sales/viewStudents/{{$course_id}}/{{$course_name}}/{{$start_date}}/{{$end_date}}/export_pdf"><i class="fa-solid fa-file-export"></i>Export
                            PDF</a>
                    </div>

                </div>
                <table id="table" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Sex</th>
                            <th>Phone Number</th>
                            <th>Duration HRS</th>
                            <th>Price</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    </tbody>
                    @foreach ( $students as $student)
                    @php $balance = $student -> price - $student ->total_cash_payments; @endphp

                    <tr>
                        <td>
                            <div class="d-flex align-items-center" style="gap: 10px;padding:5px 0">
                                <img src="/{{$student->profile_image}}" class="rounded-circle" style="width: 40px;height:40px;object-fit: cover;" alt="Avatar" />
                                <div>
                                    <h6>{{$student->firstname}} {{$student->middlename}} {{$student->lastname}}</h6>
                                    <p style="font-size:14px" class="email">{{$student->email}} </p>
                                </div>
                            </div>
                        </td>

                        <td>{{$student -> sex}}</td>
                        <td>{{$student -> phone_number}}</td>
                        <td>{{$student -> duration}}</td>
                        <td>{{number_format($student -> price, 2)}}</td>
                        <td>{{number_format($balance, 2)}}</td>
                    </tr>
                    @endforeach
                    </tbody>


                </table>
            </div>
        </div>
    </div>

</div>


<script>
    $('#filterbutton').click(function() {
        var duration = $('#duration').val();
        var course_id = $('#course_id').val();
        var course_name = $('#course_name').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();



        $.ajax({
            url: '{{route("school.filter.sales.courseViewStudents")}}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                duration: duration,
                course_id: course_id,
                course_name: course_name,
                start_date: start_date,
                end_date: end_date
            },
            success: function(response) {
                $('#filterresult').html(response);

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log("Error Thrown: " + errorThrown);
                console.log("Text Status: " + textStatus);
                console.log("XMLHttpRequest: " + XMLHttpRequest);
                console.warn(XMLHttpRequest.responseText)
            }
        });

    });
</script>

@include(SchoolFileHelper::$footer)