@include('admin.includes.header', ['title' => 'Driving School Profile'])


@php
$currentYear = date('Y');
$currentMonth = date('F');
$lastMonth = date('F', strtotime('-1 month'));

use Illuminate\Support\Str;
@endphp




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
                    'school_id' => $details->user_id,
                    ])

                    <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                    <br>





                    <h5><b>Courses & Services</b></h5>



                    <br>
                    <div class="col-11 mx-auto">

                        <div class="row">



                            @php


                            if($datarow == "None"){
                            @endphp



                            <center>
                                <h5>No Courses & Servises Posted</h5>
                            </center>


                            @php
                            }else{
                            @endphp

                            @foreach ($courses as $course)

                            <div class="col-md-6" id="thumbnail" onclick="location.href='{{ route('admin.schools.courseDetails', ['schoolID' => $details->user_id, 'courseID' => $course->id]) }}'">
                                <!--<img src="https://opensea.io/static/images/categories/art.png">-->
                                <img src="/{{($course->thumbnail) }}" alt="Thumbnail">
                                <div class="coursename"> {{$course -> name}} @php if($course->status==2){echo " is
                                    UNAVAILABLE";} @endphp</div>
                                <div class="coursedesc">{{ Str::limit($course->description, 105, ' ...') }}

                                    <p>Starts at Php</p>
                                </div>

                            </div>
                            @endforeach

                            @php
                            }
                            @endphp

                        </div>



                    </div>











                </div>
            </div>

        </div>
    </div>






</div>





@include('admin.includes.footer')