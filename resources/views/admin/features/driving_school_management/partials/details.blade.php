<!-- resources/views/partials/school_details.blade.php -->





<div class="card border">
    <center>
        <h4><b>{{ $schoolName }}</b></h4>
        Created <b>{{ $schoolDate }}</b><br>

        <img class="school_profile" src="/{{($schoolImage) }}">
    </center>
    <br>
    <center>{{ $schoolAddress }}</center>
</div>
<br>

<div class="col-xl-12">
    <div class="card border">
        <div class="col-sm-12">
            <center>
                <h5><b>Overall Rating</b></h5>
                <h1 style="font-size:5vw;">{{ $schoolRating }}</h1>

                @php
                $starVal = intval($schoolRating);
                @endphp


                @for($i = 1; $i<= $starVal; $i++) <i class="fa-solid fa-star" id="star"></i>

                    @endfor @for($i = 1; $i<= 5 - $starVal ; $i++) <i class="fa-solid fa-star" id="star2"></i>

                        @endfor
                        <br>
                        <a href="#">
                            <button class="btn3">


                                <h5>{{ $schoolReviews }} {{ $schoolReviews <= 1 ? 'review' : 'reviews' }}</h5>
                            </button>
                        </a>
            </center>
        </div>
    </div>
</div>