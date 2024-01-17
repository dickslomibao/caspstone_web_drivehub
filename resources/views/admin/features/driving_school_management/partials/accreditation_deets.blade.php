<div class="card" style="margin: 10px 0 20px 0">
    <center>
        <h4><b>{{ $schoolName }}</b></h4>
        Created <b>{{ $schoolDate }}</b><br>

        <img class="school_profile" src="/{{($schoolImage) }}">
    </center>
    <br>
    <center>{{ $schoolAddress }}</center>
</div>
<br>

<div class="card">
    <center>
        <button class="btn-add-management" id="approve">
            <i class="fa-solid fa-school-circle-check"></i> Approve Application
        </button>
    </center>
</div>
<br>