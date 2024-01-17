<script>
    $(document).ready(function() {
        $('#table1').DataTable();
    });
</script>


<div class="w-100 d-flex justify-content-between table-header-btn">
    <div class="d-flex" style="gap:15px">
        <a class="btn-outline-light" href="/school/reviews/filter/{{$rating}}/{{$start_date}}/{{$end_date}}/export_pdf"><i class="fa-solid fa-file-export"></i>Export
            PDF</a>
    </div>

</div>
<table id="table1" class="table" style="width:100%">
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
        $anonymity = $review->firstname . ' ' . $review->middlename . ' ' . $review->lastname;
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