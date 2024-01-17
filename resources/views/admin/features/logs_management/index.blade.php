@include('admin.includes.header', ['title' => 'Logs'])


<script>
    $(document).ready(function() {
        $('#table').DataTable();
    });
</script>

<div class="container-fluid" style="padding: 20px;margin-top:60px">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-sm-2"> <label for="">Management Type</label>
                    <select id="type" class='form-select mb-3' name="type" required>
                        <option value="All" selected>All</option>
                        <option value="Terms of Services Management">Terms of Services</option>
                        <option value="Privacy Policy Management">Privacy Policy</option>
                        <option value="Identification Card Management">Identification Card</option>
                        <option value="Admin Management">Admin</option>
                    </select>
                </div>
                <div class="col-sm-3" id="changeradio">
                    <label for="">Operation</label>
                    <select id="operation" class='form-select mb-3' name="operation" required>
                        <option value="1" selected>Add</option>
                        <option value="2">Edit</option>
                        <option value="3">Delete</option>
                    </select>
                </div>
                <div class="col-sm-3"><label for="">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control mb-3" required>
                </div>
                <div class="col-sm-3"> <label for="">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control mb-3" required>
                </div>
                <div class="col-1">
                    <center><br><button type="submit" id="filterbutton" class="btn btn-primary" style="background-color: var(--primaryBG);border:none">Filter</button>
                    </center>
                </div>
            </div>
            <div id="filterresult">
                <div class="w-100 d-flex justify-content-between table-header-btn">
                    <!-- <div class="d-flex" style="gap:15px">
                        <a class="btn-outline-light" href="#"><i class="fa-solid fa-file-export"></i>Export
                            PDF</a>
                    </div> -->

                </div>
                <table id="table" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Operation</th>
                            <th>Description</th>
                            <th>Management Type</th>
                            <th>Time</th>
                        </tr>
                    <tbody>
                        @foreach ( $logs as $log)
                        @php
                        $operation = '';
                        if($log->operation == 1){
                        $operation = 'Add';
                        }else if($log->operation == 2){
                        $operation = 'Edit';
                        }else if($log->operation == 3){
                        $operation = 'Delete';
                        }
                        @endphp
                        <tr>

                            <td>{{$log->name}}</td>
                            <td>{{$operation}}</td>
                            <td>{{$log->description}}</td>
                            <td>{{$log->management_type}}</td>
                            <td>{{ \Carbon\Carbon::parse($log->date_created)->format('F j, Y | h:i:s A') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>

</div>


<script>
    $(document).ready(function() {
        $('#filterbutton').click(function() {
            var type = $('#type').val();
            var operation = $('#operation').val();
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
                    url: '{{ route('admin.filter.logs') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        type: type,
                        operation: operation,
                        start_date: start_date,
                        end_date: end_date
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


    });
</script>


@include('admin.includes.footer')