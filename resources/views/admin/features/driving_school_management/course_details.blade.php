@include('admin.includes.header', ['title' => 'Driving School Courses'])


@php
$currentYear = date('Y');
$currentMonth = date('F');
$lastMonth = date('F', strtotime('-1 month'));

use Illuminate\Support\Str;
@endphp


<script>
$(document).ready(function() {
    $('#table').DataTable();

});
</script>

<div class="container-fluid" style="padding: 20px;margin-top:60px">


    <div class="container px-4 mt-20">

        <div class="row gx-4">

            <div class="col-xl-4">


                @include('admin.features.driving_school_management.partials.details', [
                'schoolName' => $details->name,
                'schoolDate' => \Carbon\Carbon::parse($details->date_created)->format('F j, Y'),
                'schoolImage' => $details->profile_image,
                'schoolAddress' => $details->address,
                'schoolRating' => $details->average_rating, // Replace with the actual rating
                'schoolReviews' => $details->total_reviews, // Replace with the actual number of reviews
                ])



            </div>



            <div class="col-xl-8">
                <div class="p-3">


                    @include('admin.features.driving_school_management.partials.new_nav', [
                    'school_id' => $course->school_id,
                    ])

                    <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                    <br>

                    <h4><b>{{ $course->name}}</b></h4>


                    <div class="col-md-9 mx-auto pt-2" id="detailsthumbnail" id="detailsthumbnail">
                        <img src="https://opensea.io/static/images/categories/art.png">

                        <!-- <img src="{{ asset($course->thumbnail) }}" alt="Thumbnail"> -->
                        <br><br>
                        <p>{{ $course->description}}</p>
                        <br>
                        <h5>Starts at Php <b></b></h5>
                    </div>














                </div>
            </div>






        </div>
    </div>


    <br>
    <div class="p-3 border" id="cont1">
        <center>
            <h4 id="title"><b>STUDENTS ENROLLED FOR THE MONTH OF <span
                        id="buwan">{{mb_strtoupper($lastMonth)}}<span></b></h4>
            <h4><b><span id="taon">{{$currentYear}}<span></b></h4>
        </center><br>


        <div class="row">

            <div class="col-md">

                <div class="row">

                    <div class="col-sm-5">

                    </div>

                    <div class="col-sm-3"><label for="">Month</label>
                        <input type="hidden" name="schoolID" id="schoolID" value="{{$course->school_id}}"
                            class="form-control mb-3" required>
                        <input type="hidden" name="courseID" id="courseID" value="{{$course->id}}"
                            class="form-control mb-3" required>
                        <select name='month' id="month" class='form-select mb-3' name="month" required>
                            <option value="January" {{$lastMonth== 'January' ? 'selected' : '' }}>January</option>
                            <option value="February" {{$lastMonth== 'February' ? 'selected' : '' }}>February</option>
                            <option value="March" {{$lastMonth== 'March' ? 'selected' : '' }}>March</option>
                            <option value="April" {{$lastMonth== 'April' ? 'selected' : '' }}>April</option>
                            <option value="May" {{$lastMonth== 'May'? 'selected' : '' }}>May</option>
                            <option value="June" {{$lastMonth== 'June' ? 'selected' : '' }}>June</option>
                            <option value="July" {{$lastMonth== 'July'? 'selected' : '' }}>July</option>
                            <option value="August" {{$lastMonth== 'August'? 'selected' : '' }}>August</option>
                            <option value="September" {{$lastMonth== 'September'? 'selected' : '' }}>September</option>
                            <option value="October" {{$lastMonth== 'October'? 'selected' : '' }}>October</option>
                            <option value="November" {{$lastMonth== 'November'? 'selected' : '' }}>November</option>
                            <option value="December" {{$lastMonth== 'December'? 'selected' : '' }}>December</option>
                        </select>


                    </div>

                    <div class="col-sm-3"> <label for="">Year</label>
                        <input type="number" name="year" id="year" value="{{$currentYear}}" class="form-control mb-3"
                            required>

                    </div>

                    <div class="col-1">
                        <center><br><button type="submit" id="filterbutton" class="btn btn-primary">Filter</button>
                        </center>
                    </div>


                </div>

            </div>
        </div>

        <div id="filterresult">
            <table id="table" class="table" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Student Name</th>
                        <th>Email</th>
                        <th>Registration Date</th>
                        <th>Status</th>
                    </tr>
                <tbody>
                    @foreach ($students as $student)
                    <tr>
                        <td><img src="/{{$student->profile_image}}" class="rounded-circle"
                                style="width: 40px; height: 40px" alt="Avatar" /></td>
                        <td>{{$student -> firstname . ' '. $student -> middlename . ' '. $student -> lastname }}</td>
                        <td>{{$student -> email}}</td>
                        <td>{{ \Carbon\Carbon::parse($student -> date_created)->format('F j, Y') }}</td>
                        <td>{{$student -> status}}</td>
                    </tr>
                    @endforeach

                </tbody>
                </thead>

            </table>
        </div>

    </div>








</div>


<script>
$(document).ready(function() {

    $('#filterbutton').click(function() {

        var year = $('#year').val();
        var month = $("#month").val();
        var schoolID = $('#schoolID').val();
        var courseID = $('#courseID').val();

        let newmonth = month.toUpperCase();
        $('#taon').text(year);
        $('#buwan').text(newmonth);


        $.ajax({
            url: '{{route("admin.filter.courseStudent") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                year: year,
                month: month,
                schoolID: schoolID,
                courseID: courseID
            },
            success: function(html) {
                $('#filterresult').html(html);
                console.log(html); // Update the content of the div
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





@include('admin.includes.footer')