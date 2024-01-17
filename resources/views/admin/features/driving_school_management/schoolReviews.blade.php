@include('admin.includes.header', ['title' => 'Driving School Reviews'])


@php
$currentYear = date('Y');
$currentMonth = date('F');
$lastMonth = date('F', strtotime('-1 month'));
@endphp




<script>
    $(document).ready(function() {
        $('#table').DataTable();
        $('#table2').DataTable();
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
                <div class="card border">


                    @include('admin.features.driving_school_management.partials.new_nav', [
                    'school_id' => $details->user_id,
                    ])

                    <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                    <br>




                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-sm-2"> <label for="">Rating <i class="fa-solid fa-star" id="logo1"></i></label>
                                    <select id="rating" class='form-select mb-3' name="rating" required>
                                        <option value="0" selected>All</option>
                                        <option value="1">1 </option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                                <div class="col-sm-2" id="changeradio">
                                </div>
                                <div class="col-sm-3"><label for="">Start Date</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control mb-3" required>
                                    <input type="hidden" name="school_id" id="school_id" value="{{$details->user_id}}" required>
                                </div>
                                <div class="col-sm-3"> <label for="">End Date</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control mb-3" required>
                                </div>
                                <div class="col-2">
                                    <center><br><button type="submit" id="filterbutton" class="btn btn-primary">Filter</button></center>
                                </div>
                            </div>
                            <br>
                            <div id="filterresult">

                                <table id="table" class="table" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Rating</th>
                                            <th>Course</th>
                                            <th>Duration</th>
                                            <th>Date Created</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $reviews as $review)
                                        @php

                                        $anonymity = "";
                                        if($review->anonymous == 1){
                                        $anonymity = "Initials Hidden";
                                        }else{
                                        $anonymity = $review->firstname . ' ' . $review->middlename . ' ' .
                                        $review->lastname;
                                        }
                                        @endphp
                                        <td>{{ $anonymity}}</td>
                                        <td>{{$review->rating}} <i class="fa-solid fa-star" id="logo1"></i></td>
                                        <td> {{$review->name}}</td>
                                        <td> {{$review->duration}}</td>
                                        <td>{{ \Carbon\Carbon::parse($review -> date_created)->format('F j, Y') }}</td>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <!-- enddddddddd -->


                </div>
            </div>

        </div>
    </div>








</div>

<script>
    $('#filterbutton').click(function() {
        var rating = $('#rating').val();
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        var school_id = $("#school_id").val();

        var startDateObj = new Date(start_date);
        var endDateObj = new Date(end_date);



        if (!start_date && !end_date) {
            swal({
                icon: "error",
                title: 'Both Start Date and End Date are Empty',
                text: " ",

            });
        } else if (!start_date || !end_date) {
            swal({
                icon: "error",
                title: 'Invalid Date Range There is an Empty Date',
                text: " ",

            });
        } else if ((startDateObj > endDateObj) || (endDateObj < startDateObj)) {
            swal({
                icon: "error",
                title: 'Invalid Date Range',
                text: " ",
            });
        } else {
            $.ajax({
                url: '{{route("admin.school.filter.reviews")}}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    rating: rating,
                    start_date: start_date,
                    end_date: end_date,
                    school_id: school_id,
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
        }
    });
</script>













@include('admin.includes.footer')