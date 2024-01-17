<script>
$(document).ready(function() {
    $('#table1').DataTable();
});
</script>


<div class="w-100 d-flex justify-content-between table-header-btn">
    <div class="d-flex" style="gap:15px">
        <a class="btn-outline-light"
            href="/school/reports/course/Sales/viewStudents/{{$course_id}}/{{$course_name}}/{{$start_date}}/{{$end_date}}/{{$duration}}/export_pdf"><i
                class="fa-solid fa-file-export"></i>Export
            PDF</a>
    </div>

</div>
<table id="table1" class="table" style="width:100%">
    <thead>
        <tr>
            <th>Name</th>
            <th>Sex</th>
            <th>Phone Number</th>
            <th>Duration HR</th>
            <th>Price</th>
            <th>Balance</th>
        </tr>
    </thead>
    </tbody>
    @foreach ( $students as $student)
    @php $balance = $student -> price - $student ->total_cash_payments; @endphp

    <tr>
        <td>
            <div class="d-flex align-items-center" style="gap: 10px;padding:5px 0">
                <img src="/{{$student->profile_image}}" class="rounded-circle"
                    style="width: 40px;height:40px;object-fit: cover;" alt="Avatar" />
                <div>
                    <h6>{{$student->firstname}} {{$student->middlename}} {{$student->lastname}}</h6>
                    <p style="font-size:14px" class="email">{{$student->email}} </p>
                </div>
            </div>
        </td>

        <td>{{$student -> sex}}</td>
        <td>{{$student -> phone_number}}</td>
        <td>{{$student -> duration}}</td>
        <td>{{number_format($student -> price)}}</td>
        <td>{{number_format($balance, 2)}}</td>
    </tr>
    @endforeach
    </tbody>


</table>