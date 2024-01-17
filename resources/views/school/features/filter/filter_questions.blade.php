<script>
$(document).ready(function() {
    $('#table1').DataTable();
});
</script>



<div class="w-100 d-flex justify-content-between table-header-btn">
    <div class="d-flex" style="gap:15px">
        <a class="btn-outline-light" href="/school/questions/{{$status}}/{{$start_date}}/{{$end_date}}/export_pdf"><i
                class="fa-solid fa-file-export"></i>Export
            PDF</a>
    </div>
    <a href="{{ route('create.question') }}">
        <button class="btn-add-management" id="modal_btn"><i class="fa-solid fa-plus"></i> Add new
            question</button>
    </a>
</div>

<table id="table1" class="table1" style="width:100%">
    <thead>
        <tr>
            <th>Question</th>
            <th>Answer</th>
            <th>Status</th>
            <th>Date Created</th>
            <th width="50">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ( $questions as $question)

        @php
        $statusClass = '';

        if ($question->status == 1) {
        $status = '&#8226 Available';
        $statusClass = 'available';
        } else if ($question->status == 2) {
        $status = '&#8226 Not Available';
        $statusClass = 'not-available';
        }
        @endphp

        <tr>
            <td>
                {{$question->questions}}
            </td>
            <td>
                {{$question->body}}
            </td>
            <td><span class="{{ $statusClass }}">{!! $status !!}</span></td>
            <td>{{ \Carbon\Carbon::parse($question->date_created)->format('F j, Y - h:i:s A') }}</td>
            <td>
                <div class="dropdown">
                    <i class="dropdown-toggle fa-solid fa-gears" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">

                    </i>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="">More Details</a></li>
                        <li><a class="dropdown-item update" href="/school/question/update/page/{{$question->id}}"
                                role="button">Update</a></li>
                        <li><a class="dropdown-item delete" href="#">Delete</a></li>
                    </ul>
                </div>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>