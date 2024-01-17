@include('admin.includes.header', ['title' => 'Driving School Requirements'])


@php
$currentYear = date('Y');
$currentMonth = date('F');
$lastMonth = date('F', strtotime('-1 month'));





$application_percent = 0;
$percent = 0;
$documents = [];

if ($firstValidID[0]->validID1 != '') {
$application_percent++;
}

if ($firstValidID[0]->validID2 != '') {
$application_percent++;
}

if(($firstValidID[0]->validID1 == '') && ($firstValidID[0]->validID2 == '')){
$documents[] = "2 Identification Card";
}else if(($firstValidID[0]->validID1 == '') || ($firstValidID[0]->validID2 == '')){
$documents[] = "1 Identification Card";
}



if ($firstValidID[0]->DTI != '') {
$application_percent++;
}else{
$documents[] = "DTI";
}

if ($firstValidID[0]->LTO != '') {
$application_percent++;
}else{
$documents[] = "LTO";
}

if ($firstValidID[0]->city_permit != '') {
$application_percent++;
}else{
$documents[] = "Municipality Permit";
}

if ($firstValidID[0]->BFP != '') {
$application_percent++;
}else{
$documents[] = "BFP";
}


$percent = ($application_percent/6) * 100;
$total = number_format($percent, 2);

$minus = (100-$total);


$totalDocuments = count($documents);
$remainingDocs = "";

if ($totalDocuments > 0) {
$remainingDocs .= $documents[0];

if ($totalDocuments > 1) {
for ($i = 1; $i < $totalDocuments; $i++) { $remainingDocs .=", " . $documents[$i]; } } } @endphp <input type="hidden" value="{{$schoolID}}" name="schoolID" id="schoolID"">

<div class=" container-fluid" style="padding: 20px;margin-top:60px">
    <div class="container px-4 mt-20">

        <div class="row gx-4">

            <div class="col-xl-4">


                @include('admin.features.driving_school_management.partials.accreditation_deets', [
                'schoolName' => $details->name,
                'schoolDate' => \Carbon\Carbon::parse($details->date_created)->format('F j, Y'),
                'schoolImage' => $details->profile_image,
                'schoolAddress' => $details->address,
                ])






            </div>

            <div class="col-xl-8">






                <!-- newwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww-->

                <div class="card" style="margin: 10px 0 20px 0">



                    <div class="col-lg-5 mx-auto">
                        <center>
                            <h5>Application Progress</h5>

                            <canvas id="applicationChart" style="width:100%;max-width:600px"></canvas>
                            <br>
                            @if ($minus > 0)
                            <b>Remaining Documents:</b> {{$remainingDocs}}
                            @endif
                        </center>
                    </div>
                    <br>

                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Identification Card</button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Business
                                Documents Requirements</button>
                        </div>
                    </nav>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                            <!-- start  of  Identification  -->

                            <div class="col mt-3">

                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                                            @if ($datarow == 'None')

                                            Identification Card

                                            @else
                                            @php

                                            $stringName = '';
                                            @endphp



                                            @foreach ($identification as $data )

                                            @if ($data->id == $firstValidID[0]->ID1_type )
                                            @php $stringName = $data->title; @endphp

                                            @endif
                                            @endforeach

                                            {{$stringName}}

                                            @endif

                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">
                                            @if ($checkvalidID2 == 'None')

                                            Identification Card

                                            @else
                                            @php

                                            $stringName = '';
                                            @endphp



                                            @foreach ($identification as $data )

                                            @if ($data->id == $firstValidID[0]->ID2_type )
                                            @php $stringName = $data->title; @endphp

                                            @endif
                                            @endforeach

                                            {{$stringName}}

                                            @endif
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">



                                        @if($datarow == "None")

                                        <div class="alert alert-danger col-11 mx-auto">
                                            <center>
                                                <h6>No valid ID has been uploaded yet.</h6>
                                            </center>
                                        </div>


                                        @else
                                        @php

                                        $stringType= "";

                                        @endphp


                                        @foreach ($identification as $data )

                                        @if ($data->id == $firstValidID[0]->ID1_type )
                                        @php $stringType = $data->title; @endphp

                                        @endif
                                        @endforeach
                                        <div class="col-11 mx-auto">
                                            <div class="row">
                                                <div class="col-sm-6"><b>Type of Identification Card: </b> {{ $stringType }}</div>
                                                <div class="col-sm-6 text-end"><span style="color: blue;"><a href="#" class="dropdown-item update-ValidID" data-id_no_update="validID1"><i class="fa-solid fa-pen-to-square"></i> Update Identification Card</a> </span></div>
                                            </div>

                                        </div>



                                        @php $extension = strtolower(pathinfo( $firstValidID[0]->validID1, PATHINFO_EXTENSION));

                                        // Define allowed image extensions
                                        $allowedImageExtensions = ['jpg', 'jpeg', 'png'];

                                        // Check if it's an image or PDF
                                        if ($extension === 'pdf') {

                                        @endphp
                                        <div id="pdfContainer" class="col-11 mx-auto">
                                            <object data="/{{ $firstValidID[0]->validID1 }}" type="application/pdf" width="100%" height="500">
                                            </object>
                                            If you are unable to view the PDF, you can <a href="/{{ $firstValidID[0]->validID1 }}">download
                                                it
                                                here</a>.
                                        </div>

                                        @php

                                        } elseif (in_array($extension, $allowedImageExtensions)) {
                                        @endphp
                                        <div id="imageContainer" class="col-11 mx-auto">

                                            <img class="img-fluid" style="border-radius: 10px" src="/{{ $firstValidID[0]->validID1 }}" alt="" srcset="">
                                            <br>
                                            If you are unable to view the Image, you can <a target="_blank" href="/{{ $firstValidID[0]->validID1 }}">download
                                                it
                                                here</a>.

                                        </div>

                                        @php
                                        } @endphp
                                        @endif

                                        <br>
                                    </div>
                                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">



                                        @if($checkvalidID2 == "None")

                                        <div class="alert alert-danger col-11 mx-auto">
                                            <center>
                                                <h6>No valid ID has been uploaded yet.</h6>
                                            </center>
                                        </div>


                                        @else


                                        @php

                                        $stringType= "";

                                        @endphp


                                        @foreach ($identification as $data )

                                        @if ($data->id == $firstValidID[0]->ID2_type )
                                        @php $stringType = $data->title; @endphp

                                        @endif
                                        @endforeach


                                        <div class="col-11 mx-auto">
                                            <div class="row">
                                                <div class="col-sm-6"><b>Type of Identification Card: </b> {{ $stringType }}</div>
                                                <div class="col-sm-6 text-end"><span style="color: blue;"><a href="#" class="dropdown-item update-ValidID" data-id_no_update="validID2"><i class="fa-solid fa-pen-to-square"></i> Update Identification Card</a> </span></div>
                                            </div>

                                        </div>





                                        @php $extension = strtolower(pathinfo( $firstValidID[0]->validID2, PATHINFO_EXTENSION));


                                        $allowedImageExtensions = ['jpg', 'jpeg', 'png'];


                                        if ($extension === 'pdf') {

                                        @endphp
                                        <div id="pdfContainer" class="col-11 mx-auto">
                                            <object data="/{{ $firstValidID[0]->validID2 }}" type="application/pdf" width="100%" height="500">
                                            </object>
                                            If you are unable to view the PDF, you can <a href="/{{ $firstValidID[0]->validID2 }}">download
                                                it
                                                here</a>.
                                        </div>
                                        @php

                                        } elseif (in_array($extension, $allowedImageExtensions)) {

                                        @endphp

                                        <div id="imageContainer" class="col-11 mx-auto">

                                            <img class="img-fluid" style="border-radius: 10px" src="/{{ $firstValidID[0]->validID2 }}" alt="" srcset="">
                                            <br>
                                            If you are unable to view the Image, you can <a target="_blank" href="/{{ $firstValidID[0]->validID2 }}">download
                                                it
                                                here</a>.

                                        </div>
                                        @php

                                        } @endphp
                                        @endif

                                        <br>


                                    </div>

                                </div>
                            </div>

                            <!-- end of  Identification  -->
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                            <!-- start  of  business  -->

                            <div class="col mt-3">

                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pills-dti-tab" data-bs-toggle="pill" data-bs-target="#pills-dti" type="button" role="tab" aria-controls="pills-dti" aria-selected="true">DTI SEC Registration</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-lto-tab" data-bs-toggle="pill" data-bs-target="#pills-lto" type="button" role="tab" aria-controls="pills-lto" aria-selected="false">LTO Driving School
                                            Accreditation Permit</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-city-tab" data-bs-toggle="pill" data-bs-target="#pills-city" type="button" role="tab" aria-controls="pills-city" aria-selected="false">City/Municipality
                                            Permit</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-bfp-tab" data-bs-toggle="pill" data-bs-target="#pills-bfp" type="button" role="tab" aria-controls="pills-bfp" aria-selected="true">BFP Fire and Safety
                                            Permit</button>
                                    </li>

                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-dti" role="tabpanel" aria-labelledby="pills-dti-tab" tabindex="0">


                                        @if($checkDTI == "None")

                                        <div class="alert alert-danger col-11 mx-auto">
                                            <center>
                                                <h6>No DTI SEC Registration has been uploaded yet.</h6>
                                            </center>
                                        </div>


                                        @else



                                        @php $extension = strtolower(pathinfo( $firstValidID[0]->DTI, PATHINFO_EXTENSION));
                                        $allowedImageExtensions = ['jpg', 'jpeg', 'png'];
                                        if ($extension === 'pdf') {

                                        @endphp
                                        <div id="pdfContainer" class="col-11 mx-auto">
                                            <object data="/{{ $firstValidID[0]->DTI }}" type="application/pdf" width="100%" height="500">
                                            </object>
                                            If you are unable to view the PDF, you can <a href="/{{ $firstValidID[0]->DTI }}">download
                                                it
                                                here</a>.
                                        </div>
                                        @php

                                        } elseif (in_array($extension, $allowedImageExtensions)) {

                                        @endphp

                                        <div id="imageContainer" class="col-11 mx-auto">

                                            <img class="img-fluid" style="border-radius: 10px" src="/{{ $firstValidID[0]->DTI }}" alt="" srcset="">
                                            <br>
                                            If you are unable to view the Image, you can <a target="_blank" href="/{{ $firstValidID[0]->DTI }}">download
                                                it
                                                here</a>.

                                        </div>
                                        @php

                                        }
                                        @endphp
                                        @endif

                                        <br>


                                    </div>
                                    <div class="tab-pane fade" id="pills-lto" role="tabpanel" aria-labelledby="pills-lto-tab" tabindex="0">

                                        @if($checkLTO == "None")

                                        <div class="alert alert-danger col-11 mx-auto">
                                            <center>
                                                <h6>No LTO Driving School Accreditation Permit has been uploaded yet.
                                                </h6>
                                            </center>
                                        </div>

                                        @else



                                        @php $extension = strtolower(pathinfo( $firstValidID[0]->LTO, PATHINFO_EXTENSION));
                                        $allowedImageExtensions = ['jpg', 'jpeg', 'png'];
                                        if ($extension === 'pdf') {

                                        @endphp
                                        <div id="pdfContainer" class="col-11 mx-auto">
                                            <object data="/{{ $firstValidID[0]->LTO }}" type="application/pdf" width="100%" height="500">
                                            </object>
                                            If you are unable to view the PDF, you can <a href="/{{ $firstValidID[0]->LTO }}">download
                                                it
                                                here</a>.
                                        </div>
                                        @php

                                        } elseif (in_array($extension, $allowedImageExtensions)) {

                                        @endphp

                                        <div id="imageContainer" class="col-11 mx-auto">

                                            <img class="img-fluid" style="border-radius: 10px" src="/{{ $firstValidID[0]->LTO }}" alt="" srcset="">
                                            <br>
                                            If you are unable to view the Image, you can <a target="_blank" href="/{{ $firstValidID[0]->LTO }}">download
                                                it
                                                here</a>.

                                        </div>
                                        @php

                                        }
                                        @endphp

                                        @endif

                                        <br>

                                    </div>
                                    <div class="tab-pane fade" id="pills-city" role="tabpanel" aria-labelledby="pills-city-tab" tabindex="0">



                                        @if($checkcity == "None")

                                        <div class="alert alert-danger col-11 mx-auto">
                                            <center>
                                                <h6>No City/Municipality Permit has been uploaded yet.</h6>
                                            </center>
                                        </div>


                                        @else



                                        @php $extension = strtolower(pathinfo( $firstValidID[0]->city_permit, PATHINFO_EXTENSION));
                                        $allowedImageExtensions = ['jpg', 'jpeg', 'png'];
                                        if ($extension === 'pdf') {

                                        @endphp
                                        <div id="pdfContainer" class="col-11 mx-auto">
                                            <object data="/{{ $firstValidID[0]->city_permit }}" type="application/pdf" width="100%" height="500">
                                            </object>
                                            If you are unable to view the PDF, you can <a href="/{{ $firstValidID[0]->city_permit }}">download
                                                it
                                                here</a>.
                                        </div>
                                        @php

                                        } elseif (in_array($extension, $allowedImageExtensions)) {

                                        @endphp

                                        <div id="imageContainer" class="col-11 mx-auto">

                                            <img class="img-fluid" style="border-radius: 10px" src="/{{ $firstValidID[0]->city_permit }}" alt="" srcset="">
                                            <br>
                                            If you are unable to view the Image, you can <a target="_blank" href="/{{ $firstValidID[0]->city_permit }}">download
                                                it
                                                here</a>.

                                        </div>
                                        @php

                                        }
                                        @endphp
                                        @endif

                                        <br>

                                    </div>
                                    <div class="tab-pane fade show" id="pills-bfp" role="tabpanel" aria-labelledby="pills-bfp-tab" tabindex="0">



                                        @if($checkBFP == "None")

                                        <div class="alert alert-danger col-11 mx-auto">
                                            <center>
                                                <h6>No BFP Fire and Safety Permit has been uploaded yet.</h6>
                                            </center>
                                        </div>


                                        @else



                                        @php $extension = strtolower(pathinfo( $firstValidID[0]->BFP, PATHINFO_EXTENSION));
                                        $allowedImageExtensions = ['jpg', 'jpeg', 'png'];
                                        if ($extension === 'pdf') {

                                        @endphp
                                        <div id="pdfContainer" class="col-11 mx-auto">
                                            <object data="/{{ $firstValidID[0]->BFP }}" type="application/pdf" width="100%" height="500">
                                            </object>
                                            If you are unable to view the PDF, you can <a href="/{{ $firstValidID[0]->BFP }}">download
                                                it
                                                here</a>.
                                        </div>
                                        @php

                                        } elseif (in_array($extension, $allowedImageExtensions)) {

                                        @endphp

                                        <div id="imageContainer" class="col-11 mx-auto">

                                            <img class="img-fluid" style="border-radius: 10px" src="/{{ $firstValidID[0]->BFP }}" alt="" srcset="">
                                            <br>
                                            If you are unable to view the Image, you can <a target="_blank" href="/{{ $firstValidID[0]->BFP }}">download
                                                it
                                                here</a>.

                                        </div>
                                        @php

                                        }
                                        @endphp
                                        @endif

                                        <br>

                                    </div>
                                </div>

                            </div>

                            <!-- end of business -->

                        </div>

                    </div>
                </div>








            </div>

        </div>
    </div>







    </div>





    <script>
        var total = <?php echo $total; ?>;
        var minus = <?php echo $minus; ?>;
        var documents = "<?php echo $remainingDocs; ?>";


        var xValues = ["Percentage of Completion: " + total + "%", "Remaining Documents: " + minus + "%"];
        var yValues = [total, minus];
        //var yValues = [0, 0, 0];
        var barColors = [
            "#545ee1",
            "#abacba",
        ];

        new Chart("applicationChart", {
            type: "doughnut",

            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Application Progress'
                }
            }

        });



        $(document).ready(function() {


            $('#approve').click(function() {


                var schoolID = $('#schoolID').val();

                swal({
                    title: "Approve the Application?",
                    text: "Are you sure you that the Driving School is Accredited? ",
                    icon: "warning",
                    buttons: {
                        cancel: "Cancel",
                        yes: {
                            text: "Yes",
                            value: "yes",
                        },

                    },
                }).then((value) => {
                    if (value === "yes") {
                        $.ajax({
                            url: '{{route("admin.school.approve.accreditation") }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                schoolID: schoolID,
                            },
                            success: function(response) {

                                if (response.code == 200) {
                                    swal({
                                        icon: "success",
                                        title: 'Accreditation Approved!',
                                        text: " ",
                                        timer: 2000,
                                        showConfirmButton: false,
                                    }).then(function() {
                                        window.location.href =
                                            "{{ route('admin.pendingSchool') }}";
                                    });
                                }

                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                                console.log("Error Thrown: " + errorThrown);
                                console.log("Text Status: " + textStatus);
                                console.log("XMLHttpRequest: " + XMLHttpRequest);
                                console.warn(XMLHttpRequest.responseText)
                            }
                        });
                    } else {

                    }
                });

            });

        });
    </script>




    @include('admin.includes.footer')