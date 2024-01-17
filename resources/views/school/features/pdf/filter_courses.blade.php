<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>List of Instructors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
        }

        table,
        th,
        td {
            padding: 4px;
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 12px;
            font-family: 'Times New Roman', Times, serif;
        }


        th {
            background-color: rgb(10, 10, 28);
            color: white;
        }

        footer {
            width: 100%;
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            height: 100px;
            color: #000;
            text-align: right;
            line-height: 35px;
            border-top: 1px solid #000;
            font-size: 12px;
        }
    </style>
</head>

<?php

$title = "";
$statusString = "";

if ($status == 1) {
    $statusString = 'Available';
} else if ($status == 2) {
    $statusString = 'Unavailable';
}



if ($status == 0) {
    $title = "LIST OF COURSES";
} else {
    $title = "LIST OF COURSES: STATUS - " . $statusString;
}



if ($start_date == $end_date) {
    $date = new DateTime($start_date);
    $formattedDate = $date->format('F j, Y');
    $dateString = "FROM " . $formattedDate;
} else {

    $firstdate = new DateTime($start_date);
    $secdate = new DateTime($end_date);
    $formattedDate1 = $firstdate->format('M d, Y');
    $formattedDate2 = $secdate->format('M d, Y');

    $dateString = "FROM " . $formattedDate1 . " TO " . $formattedDate2;
}

?>


<body>


    <div class="col-11 mx-auto m-3">

        <center>

            <h3>{{strtoupper($school -> name)}}</h3>
            <h6>{{$school -> address}}</h6>
            <h6>Open From:
                @if($openHours->type == 1)
                Monday - Saturday
                @else
                Monday - Sunday
                @endif 
                {{ Carbon\Carbon::createFromFormat('H:i:s', $openHours->opening_time)->format('g:i A') }} -
                {{ Carbon\Carbon::createFromFormat('H:i:s', $openHours->closing_time)->format('g:i A') }}
            </h6>
            <h6>Email: {{$school -> email}}</h6>

        </center>

        <div style="margin-top: 20px;">
            <center>
                <h4><b>{{strtoupper($title)}} {{strtoupper($dateString)}}</b></h4>

            </center>
            <br>

            <div style="font-size: 14px; margin-bottom:2px;">
                <b>Prepared by:</b> {{$name}}<br>
                <b>Date of Report: </b> {{ now()->format('F d, Y') }}
            </div>
        </div>

        <hr>



        <table style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @if(count($courses))
                @foreach ( $courses as $course)


                @php
                $statusClass = '';

                if ($course->status == 1) {
                $status = 'Available';
                } else if ($course->status == 2) {
                $status = 'Not Available';
                }
                @endphp

                <tr>
                    <td>{{$course -> name}}</td>
                    <td>
                        {{$course-> type == 1 ? 'Practical' : 'Theoretical' }}
                    </td>
                    <td>{{$course -> description}}</td>

                    <td>{{$status}}</td>
                </tr>
                @endforeach
                @else

                <tr>
                    <td colspan="4">
                        <center>No Data Available</center>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    <footer class="text-right">
        <p class="pr-3 m-0"> DriveHub Solutions: Steer Your Learning Journey</p>
    </footer>
</body>


</html>