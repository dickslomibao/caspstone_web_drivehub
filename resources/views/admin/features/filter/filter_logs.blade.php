<script>
    $(document).ready(function() {
        $('#table1').DataTable();
    });
</script>


<div class="w-100 d-flex justify-content-between table-header-btn">
    <!-- <div class="d-flex" style="gap:15px">
                        <a class="btn-outline-light" href="#"><i class="fa-solid fa-file-export"></i>Export
                            PDF</a>
                    </div> -->

</div>
<table id="table1" class="table" style="width:100%">
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