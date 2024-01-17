@include(SchoolFileHelper::$header, ['title' => 'Reviews'])
<script>
    $(document).ready(function() {
        $('#table').DataTable();
    });
</script>
<div class="container-fluid" style="padding: 20px;margin-top:50px">
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
                <div class="col-sm-3" id="changeradio">
                </div>
                <div class="col-sm-3"><label for="">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control mb-3" required>
                </div>
                <div class="col-sm-3"> <label for="">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control mb-3" required>
                </div>
                <div class="col-1">
                    <center><br><button type="submit" id="filterbutton" class="btn btn-primary">Filter</button>
                    </center>
                </div>
            </div>
            <div id="filterresult">
                <div class="w-100 d-flex justify-content-between table-header-btn">
                    <div class="d-flex" style="gap:15px">
                        <a class="btn-outline-light" href="{{ route('reviews.export.pdf') }}"><i
                                class="fa-solid fa-file-export"></i>Export
                            PDF</a>
                    </div>

                </div>
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
                        @foreach ($reviews as $review)
                            @php

                                $anonymity = '';
                                if ($review->anonymous == 1) {
                                    $anonymity = 'Initials Hidden';
                                } else {
                                    $anonymity = $review->firstname . ' ' . $review->middlename . ' ' . $review->lastname;
                                }
                            @endphp
                            <td>{{ $anonymity }}</td>
                            <td>{{ $review->rating }} <i class="fa-solid fa-star" id="logo1"></i></td>
                            <td> {{ $review->name }}</td>
                            <td> {{ $review->duration }}</td>
                            <td>{{ \Carbon\Carbon::parse($review->date_created)->format('F j, Y') }}</td>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $('#filterbutton').click(function() {
        var rating = $('#rating').val();
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();

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
                url: '{{ route('school.filter.reviews') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    rating: rating,
                    start_date,
                    end_date,
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
@include(SchoolFileHelper::$footer)
