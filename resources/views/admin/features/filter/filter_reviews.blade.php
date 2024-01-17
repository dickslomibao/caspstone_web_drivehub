<script>
$(document).ready(function() {
    $('#table1').DataTable();
});
</script>



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