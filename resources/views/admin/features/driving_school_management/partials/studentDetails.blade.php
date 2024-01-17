<!-- resources/views/partials/school_details.blade.php -->


<div class="p-3 border" id="cont1">
    <center>
        <h4><b>{{$firstName .' '.$middleName.' '.$lastName}}</b></h4>

        Created <b>{{ $registrationDate }}</b><br>
        <img class="school_profile" src="/{{($studentImage) }}">
    </center>
    <br>
    <center> Address</center>
</div>
<br>

<div class="col-xl-12">
    <div class="p-3 border" id="cont1">

        <div class="col-sm-12">
            <center>
                <h5><b>No. of Availed Courses</b></h5>
                <h1 style="font-size:5vw;">{{ $orderCount }}</h1>

            </center>
        </div>


    </div>
</div>