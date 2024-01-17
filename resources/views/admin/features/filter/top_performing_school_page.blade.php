@include('admin.includes.header', ['title' => 'Top Performing School'])


@php
$currentYear = date('Y');
$currentMonth = date('F');
$lastMonth = date('F', strtotime('-1 month'));

@endphp


<script>
    $(document).ready(function() {

        $('#table').DataTable();
    });
</script>


<div class="container-fluid" style="padding: 20px;margin-top:60px">
    <div class="col-10 mx-auto">
        <div class="card border">




            <div class="row">

                <div class="col-sm-5">

                </div>

                <div class="col-sm-3"><label for="">Month</label>
                    <select name='month' id="month" class='form-select mb-3' name="month" required>
                        <option value="January" {{$currentMonth== 'January' ? 'selected' : '' }}>January</option>
                        <option value="February" {{$currentMonth== 'February' ? 'selected' : '' }}>February</option>
                        <option value="March" {{$currentMonth== 'March' ? 'selected' : '' }}>March</option>
                        <option value="April" {{$currentMonth== 'April' ? 'selected' : '' }}>April</option>
                        <option value="May" {{$currentMonth== 'May'? 'selected' : '' }}>May</option>
                        <option value="June" {{$currentMonth== 'June' ? 'selected' : '' }}>June</option>
                        <option value="July" {{$currentMonth== 'July'? 'selected' : '' }}>July</option>
                        <option value="August" {{$currentMonth== 'August'? 'selected' : '' }}>August</option>
                        <option value="September" {{$currentMonth== 'September'? 'selected' : '' }}>September</option>
                        <option value="October" {{$currentMonth== 'October'? 'selected' : '' }}>October</option>
                        <option value="November" {{$currentMonth== 'November'? 'selected' : '' }}>November</option>
                        <option value="December" {{$currentMonth== 'December'? 'selected' : '' }}>December</option>
                    </select>


                </div>

                <div class="col-sm-3"> <label for="">Year</label>
                    <input type="number" name="year" id="year" value="{{$currentYear}}" class="form-control mb-3" required>

                </div>

                <div class="col-1">
                    <center><br><button type="submit" id="filterbutton" class="btn btn-primary">Filter</button>
                    </center>
                </div>


            </div>


            <div id="filterresult">
                <br>

                <center>
                    <h5 id="title"><b> Top Performing School {{$currentMonth }} {{$currentYear}}
                        </b>
                    </h5>
                </center>


                <div class="row">
                    <div class="col-12 mx-auto">

                        <table id="table" class="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>
                                    </th>
                                    <th>Driving School</th>
                                    <th>Location</th>
                                    <th>No. of Booked Order</th>
                                    <th>Completion Rate</sth>
                                    <th>Average Rate</th>


                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($topSchool as $school)

                                @php

                                $address = $school->address;
                                $addressParts = explode(',', $address);

                                $city = trim($addressParts[count($addressParts) - 3]);
                                $province = trim($addressParts[count($addressParts) - 2]);

                                @endphp
                                <tr>
                                    <td>
                                        <img src="/{{($school->profile_image) }}" class="rounded-circle" style="width: 40px; height: 40px" alt="Avatar" />
                                    <td>{{ $school->name }}</td>
                                    <td>{{ $city . ', ' .$province}}</td>
                                    <td>{{ $school-> availed_service_count}}</td>
                                    <td>{{ $school->completion_rate}} % </td>
                                    <td>{{ $school->average_rating}} <i class="fa-solid fa-star" id="logo1"></i></td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>



            </div>
        </div>


    </div>
</div>


<script>
    $(document).ready(function() {
        $('#filterbutton').click(function() {

            var year = $('#year').val();
            var month = $("#month").val();

            $.ajax({
                url: '{{route("admin.filter.topSchoolTable") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    year: year,
                    month: month,
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