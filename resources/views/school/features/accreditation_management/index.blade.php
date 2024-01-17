@php
$statusString = $status->accreditation_status == 1 ? '<span class="waiting">Pending</span>' : '<span class="completed">Approved</span>';

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

$percent = ($application_percent / 6) * 100;
$total = number_format($percent, 2);

$minus = 100 - $total;


$totalDocuments = count($documents);
$remainingDocs = "";

if ($totalDocuments > 0) {
$remainingDocs .= $documents[0];

if ($totalDocuments > 1) {
for ($i = 1; $i < $totalDocuments; $i++) { $remainingDocs .=", " . $documents[$i]; } } } @endphp @include(SchoolFileHelper::$header, ['title'=> 'Manage Accreditation'])


    <div class="container-fluid" style="padding: 20px;margin-top:60px">
        <div class="row">
            <div class="col-lg-3">

                <center>
                    <h5 style="margin-bottom: 10px">Application Progress</h5>
                    <canvas id="applicationChart" style="width:100%;max-width:600px"></canvas>
                    <br>
                    @if ($minus > 0)
                    <b>Remaining Documents:</b> {{$remainingDocs}}
                    @endif
                </center>
            </div>
            <div class="col-lg-6">
                <h6 style="margin-bottom:15px"><b>Application Status: </b>{!! $statusString !!}</h6>

                <div class="card" style="margin: 10px 0 20px 0">

                    <div class="alert alert-info">
                        <p><b>Requirements: </b> Before accreditation, the following rules and requirements shall be
                            strictly
                            followed and submitted: <b>(PDF FILES ONLY)</b>
                        </p>

                    </div>
                    <div class="row">
                        <div class="col-sm-6">

                            <p><b> a). Identification Card: </b> 2 Valid IDs: <b>Within its validity period</b></p>

                            <p><strong>List of Acceptable Government-Issued Identification Cards (IDs) /
                                    Documents</strong>
                            </p>

                            <div class="col-lg-12">
                                <ul>
                                    <li>&#8226 Employee’s ID / Office ID</li>
                                    <li>&#8226 Registration Form Philippine Identification (PhilID / ePhilID)</li>
                                    <li>&#8226 NBI Clearance*</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <p><b> b). Business Documents Requirements for Accreditation of Driving School:</b> </p>
                            <div class="col-lg-12">
                                <ul>
                                    <li>
                                        &#8226 DTI SEC Registration
                                    </li>
                                    <li>&#8226 LTO Driving School Accreditation Permit
                                    </li>
                                    <li>&#8226 City/Municipality Permit
                                    </li>
                                    <li>&#8226 BFP Fire and Safety Permit
                                    </li>
                                </ul>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
            <div class="col-lg-3">
                <h6 style="margin-bottom:15px"><b>Summary: </b></h6>
                <div class="card" style="margin: 10px 0 20px 0">

                    <ul>
                        <li>
                            @if(($firstValidID[0]->validID1 != '') && ($firstValidID[0]->validID2 != ''))
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckCheckedDisabled" checked disabled>

                            @else
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckCheckedDisabled" disabled>
                            @endif
                            2 Valid ID
                        </li>
                        <li>
                            @if ($firstValidID[0]->DTI != '')
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckCheckedDisabled" checked disabled>

                            @else
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckCheckedDisabled" disabled>
                            @endif
                            DTI SEC Registration
                        </li>
                        <li>

                            @if ($firstValidID[0]->LTO != '')
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckCheckedDisabled" checked disabled>

                            @else
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckCheckedDisabled" disabled>
                            @endif

                            LTO Driving School Accreditation Permit
                        </li>
                        <li>

                            @if ($firstValidID[0]->city_permit != '')
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckCheckedDisabled" checked disabled>

                            @else
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckCheckedDisabled" disabled>
                            @endif

                            City/Municipality Permit
                        </li>
                        <li> @if ($firstValidID[0]->BFP != '')
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckCheckedDisabled" checked disabled>

                            @else
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckCheckedDisabled" disabled>
                            @endif BFP Fire and Safety Permit
                        </li>
                    </ul>
                </div>
            </div>




            <div class="card" style="margin: 10px 0 20px 0">

                {{-- <div class="row">
                    <div class="col-6">
                        <div class="col-lg-4">
                            <center>
                                <h5>Application Progress</h5>
        
                                <canvas id="applicationChart" style="width:100%;max-width:600px"></canvas>
                            </center>
                        </div>
                    </div>
                    <div class="col-8">

                    </div>
                </div>

          --}}


                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Identification
                            Card</button>
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



                                    @if ($datarow == 'None')
                                    <div class="alert alert-danger col-11 mx-auto">
                                        <center>
                                            <h6>No valid ID has been uploaded yet.</h6>
                                        </center>
                                    </div>
                                    <center> <span style="color: blue;"><a href="#" class="dropdown-item upload-ValidID" data-id_no="validID1">Upload
                                                Now</a></center> </span>
                                    @else
                                    @php

                                    $stringType = '';
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



                                    @if ($checkvalidID2 == 'None')
                                    <div class="alert alert-danger col-11 mx-auto">
                                        <center>
                                            <h6>No valid ID has been uploaded yet.</h6>
                                        </center>
                                    </div>
                                    <center> <span style="color: blue;"><a href="#" class="dropdown-item upload-ValidID" data-id_no="validID2">Upload
                                                Now</a></center> </span>
                                    @else
                                    @php
                                    $stringType = '';
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


                                    @if ($checkDTI == 'None')
                                    <div class="alert alert-danger col-11 mx-auto">
                                        <center>
                                            <h6>No DTI SEC Registration has been uploaded yet.</h6>
                                        </center>
                                    </div>
                                    <center> <span style="color: blue;"><a href="#" class="dropdown-item upload-business" data-business_req="DTI">Upload
                                                Now</a></center> </span>
                                    @else



                                    <div class="col-11 mx-auto text-end">

                                        <span style="color: blue; "><a href="#" class="dropdown-item update-business" data-business_req_update="DTI"><i class="fa-solid fa-pen-to-square"></i> Update DTI</a> </span>
                                    </div>
                                    <br>


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

                                    @if ($checkLTO == 'None')
                                    <div class="alert alert-danger col-11 mx-auto">
                                        <center>
                                            <h6>No LTO Driving School Accreditation Permit has been uploaded yet.
                                            </h6>
                                        </center>
                                    </div>
                                    <center> <span style="color: blue;"><a href="#" class="dropdown-item upload-business" data-business_req="LTO">Upload
                                                Now</a></center> </span>
                                    @else



                                    <div class="col-11 mx-auto text-end">

                                        <span style="color: blue; "><a href="#" class="dropdown-item update-business" data-business_req_update="LTO"><i class="fa-solid fa-pen-to-square"></i> Update LTO</a> </span>
                                    </div>
                                    <br>

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



                                    @if ($checkcity == 'None')
                                    <div class="alert alert-danger col-11 mx-auto">
                                        <center>
                                            <h6>No City/Municipality Permit has been uploaded yet.</h6>
                                        </center>
                                    </div>
                                    <center> <span style="color: blue;"><a href="#" class="dropdown-item upload-business" data-business_req="city_permit">Upload
                                                Now</a></center> </span>
                                    @else



                                    <div class="col-11 mx-auto text-end">

                                        <span style="color: blue; "><a href="#" class="dropdown-item update-business" data-business_req_update="city_permit"><i class="fa-solid fa-pen-to-square"></i> Update City Permit</a> </span>
                                    </div>
                                    <br>

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



                                    @if ($checkBFP == 'None')
                                    <div class="alert alert-danger col-11 mx-auto">
                                        <center>
                                            <h6>No BFP Fire and Safety Permit has been uploaded yet.</h6>
                                        </center>
                                    </div>
                                    <center> <span style="color: blue;"><a href="#" class="dropdown-item upload-business" data-business_req="BFP">Upload
                                                Now</a></center> </span>
                                    @else




                                    <div class="col-11 mx-auto text-end">

                                        <span style="color: blue; "><a href="#" class="dropdown-item update-business" data-business_req_update="BFP"><i class="fa-solid fa-pen-to-square"></i> Update BFP</a> </span>
                                    </div>
                                    <br>


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




    <div class="modal fade" id="upload_validID_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="" id="modal_title">Upload Valid ID</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="identification_card_form" enctype="multipart/form-data">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="acceptable" class="form-label">Type of Government-Issued
                                                    Identification Cards: <i id="check-acceptable" class="fa-solid fa-check check-label" style=""></i></label>
                                                <select class="form-select" name="acceptable" id="acceptable" aria-label="Default select example" required>

                                                    <!-- new -->
                                                    @foreach ($identification as $data )
                                                    <option value="{{$data->id}}">{{$data->title}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="pdfFile" class="form-label">Valid Identification Card: <i id="check-pdfFile" class="fa-solid fa-check check-label" style=""></i></label>
                                                <!-- <input type="file" class="form-control" name="pdfFile" id="pdfFile" accept=".pdf"> -->
                                                <input type="file" class="form-control" name="pdfFile" id="pdfFile" accept=".pdf, image/*">
                                                <input type="hidden" class="form-control" name="idColumn" id="idColumn" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="padding:0 0 20px 0;">
                                        <div class="row justify-content-end">
                                            <div class="col-12">
                                                <input type="submit" class="btn-form" id="modal_add_submit" value="Add Privacy Policy">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="upload_businessReqs_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="" id="modal_title_business">Upload Business Requirement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="business_req_form" enctype="multipart/form-data">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="pdfFile" class="form-label">Business Requirement: <i id="check-pdfFile_business" class="fa-solid fa-check check-label" style=""></i></label>
                                                <input type="file" class="form-control" name="pdfFile_business" id="pdfFile_business" accept=".pdf, image/*">
                                                <input type="hidden" class="form-control" name="business_column" id="business_column" required>
                                                <input type="hidden" class="form-control" name="business_column_update" id="business_column_update">

                                            </div>
                                        </div>
                                    </div>
                                    <div style="padding:0 0 20px 0;">
                                        <div class="row justify-content-end">
                                            <div class="col-12">
                                                <input type="submit" class="btn-form" id="modal_add_submit_business" value="Add Privacy Policy">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- update of identification Card -->

    <div class="modal fade" id="update_validID_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="" id="modal_title_update">Upload Valid ID</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="identification_card_form_update" enctype="multipart/form-data">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="acceptable" class="form-label">Type of Government-Issued
                                                    Identification Cards: <i id="check-acceptable_update" class="fa-solid fa-check check-label" style=""></i></label>
                                                <select class="form-select" name="acceptable_update" id="acceptable_update" aria-label="Default select example" required>

                                                    <!-- new -->
                                                    @foreach ($identification as $data )
                                                    <option value="{{$data->id}}">{{$data->title}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="pdfFile" class="form-label">Valid Identification Card: <i id="check-pdfFile_update" class="fa-solid fa-check check-label" style=""></i></label>
                                                <input type="file" class="form-control" name="pdfFile_update" id="pdfFile_update" accept=".pdf, image/*">
                                                <input type="hidden" class="form-control" name="idColumn_update" id="idColumn_update" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="padding:0 0 20px 0;">
                                        <div class="row justify-content-end">
                                            <div class="col-12">
                                                <input type="submit" class="btn-form" id="modal_add_submit_update" value="Add Privacy Policy">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '.upload-ValidID', function() {
            $('#upload_validID_modal').modal('show');
            $('#modal_title').html('Upload Valid Identification Card');
            var IDcolumn = $(this).data('id_no');
            if (IDcolumn == "validID1") {
                $('#modal_title').html('Upload First Valid ID');
                $('#modal_add_submit').val('Add First Valid ID');
                $('#idColumn').val(IDcolumn);
            } else {
                $('#modal_title').html('Upload Second Valid ID');
                $('#modal_add_submit').val('Add Second Valid ID');
            }
            //alert(IDcolumn);
        });


        $(document).on('click', '.upload-business', function() {
            $('#upload_businessReqs_modal').modal('show');
            var update = "";
            $('#business_column_update').val(update);
            var data = $(this).data('business_req');
            if (data == "DTI") {
                $('#modal_title_business').html('Upload DTI SEC Registration');
                $('#modal_add_submit_business').val('Add DTI');
                $('#business_column').val('DTI');

            } else if (data == "LTO") {
                $('#modal_title_business').html('Upload LTO Driving School Accreditation Permit');
                $('#modal_add_submit_business').val('Add LTO Accreditation Permit');
                $('#business_column').val('LTO');
            } else if (data == "city_permit") {
                $('#modal_title_business').html('Upload City/Municipality Permit');
                $('#modal_add_submit_business').val('Add Permit');
                $('#business_column').val('city_permit');
            } else if (data == "BFP") {
                $('#modal_title_business').html('Upload BFP Fire and Safety Permit');
                $('#modal_add_submit_business').val('Add Permit');
                $('#business_column').val('BFP');
            }
            //alert(IDcolumn);
        });

        var total = <?php echo $total; ?>;
        var minus = <?php echo $minus; ?>;
        var documents = "<?php echo $remainingDocs; ?>";


        var xValues = ["Percentage of Completion: " + total + "%", "Remaining Documents: " + minus + "%"];
        var yValues = [total, minus];
        var barColors = ["#545ee1", "#abacba"];

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
                },
                tooltips: {
                    callbacks: {
                        afterLabel: function(tooltipItem, data) {
                            var label = data.labels[tooltipItem.index + 1] || '';
                            return label.replace(/\n/g, "<br>"); // Replace \n with <br> for line breaks
                        }
                    }
                }
            }
        });



        $.validator.addMethod('pdfOrImage', function(value, element) {
            // Get the file extension
            var extension = value.split('.').pop().toLowerCase();

            // Get the file input element
            var fileInput = $(element)[0];

            // Check if the extension is pdf or an image extension
            if (extension === 'pdf') {
                // For PDF, check the mimetype
                return fileInput.files.length > 0 && fileInput.files[0].type === 'application/pdf';
            } else {
                // For images, check the extension
                return ['png', 'jpg', 'jpeg'].indexOf(extension) !== -1;
            }
        }, 'Please select a valid PDF or image file.');

        $("#identification_card_form").validate({
            highlight: function(element, errorClass, validClass) {
                $("#check-" + element.id).css('display', 'none');
            },
            unhighlight: function(element, errorClass, validClass) {
                $("#check-" + element.id).css('display', 'inline-block');
            },
            rules: {
                acceptable: {
                    required: true,
                },
                pdfFile: {
                    required: true,
                    accept: 'pdf, image/*',
                },
            },
            messages: {
                acceptable: {
                    required: "Type of Government-Issued Identification Card is required",
                },
                pdfFile: {
                    required: "Pdf File or Image is required",

                }
            },
            submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('store.school.accreditation.validID') }}",
                    contentType: false,
                    processData: false,
                    data: new FormData(form),
                    success: function(response) {
                        if (response.code == 200) {
                            swal({
                                icon: "success",
                                title: 'Valid ID successfully uploaded',
                                text: " ",
                                timer: 2000,
                                showConfirmButton: false,
                            }).then(function() {
                                $('#upload_validID_modal').modal('hide');
                                window.location.href =
                                    "{{ route('accreditation.index') }}";
                            });
                        } else if (response.code == 222) {
                            swal({
                                icon: "error",
                                title: 'Identification Card Types are already in use. Please choose another type.',
                                text: " ",
                                showConfirmButton: false,
                            })
                        }
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
        $("#business_req_form").validate({
            highlight: function(element, errorClass, validClass) {
                $("#check-" + element.id).css('display', 'none');
            },
            unhighlight: function(element, errorClass, validClass) {
                $("#check-" + element.id).css('display', 'inline-block');
            },
            rules: {
                pdfFile_business: {
                    required: true,
                    accept: 'pdf, image/*',
                },
            },
            messages: {
                pdfFile_business: {
                    required: "Pdf File or Image is required",
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('store.school.accreditation.business') }}",
                    contentType: false,
                    processData: false,
                    data: new FormData(form),
                    success: function(response) {

                        if (response.code == 200) {
                            swal({
                                icon: "success",
                                title: 'Business Requirement has been successfully uploaded',
                                text: " ",
                                timer: 2000,
                                showConfirmButton: false,
                            }).then(function() {
                                $('#upload_businessReqs_modal').modal('hide');
                                window.location.href =
                                    "{{ route('accreditation.index') }}";
                            });
                        } else if (response.code == 201) {
                            swal({
                                icon: "success",
                                title: 'Business Requirement has been successfully updated',
                                text: " ",
                                timer: 2000,
                                showConfirmButton: false,
                            }).then(function() {
                                $('#upload_businessReqs_modal').modal('hide');
                                window.location.href =
                                    "{{ route('accreditation.index') }}";
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

            }
        });



        $(document).on('click', '.update-ValidID', function() {
            $('#update_validID_modal').modal('show');
            $('#modal_title_update').html('Upload Valid Identification Card');
            var IDcolumn = $(this).data('id_no_update');
            if (IDcolumn == "validID1") {
                $('#modal_title_update').html('Update First Valid ID');
                $('#modal_add_submit_update').val('Edit First Valid ID');
                $('#idColumn_update').val(IDcolumn);
            } else {
                $('#modal_title_update').html('Update Second Valid ID');
                $('#modal_add_submit_update').val('Edit Second Valid ID');
            }
            //alert(IDcolumn);
        });


        $("#identification_card_form_update").validate({
            highlight: function(element, errorClass, validClass) {
                $("#check-" + element.id).css('display', 'none');
            },
            unhighlight: function(element, errorClass, validClass) {
                $("#check-" + element.id).css('display', 'inline-block');
            },
            rules: {
                acceptable_update: {
                    required: true,
                },
                pdfFile_update: {
                    required: true,
                    accept: 'pdf, image/*',
                },
            },
            messages: {
                acceptable_update: {
                    required: "Type of Government-Issued Identification Card is required",
                },
                pdfFile_update: {
                    required: "Pdf File or Image is required",
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('update.school.accreditation.validID') }}",
                    contentType: false,
                    processData: false,
                    data: new FormData(form),
                    success: function(response) {
                        if (response.code == 200) {
                            swal({
                                icon: "success",
                                title: 'Valid ID successfully updated',
                                text: " ",
                                timer: 2000,
                                showConfirmButton: false,
                            }).then(function() {
                                $('#update_validID_modal').modal('hide');
                                window.location.href =
                                    "{{ route('accreditation.index') }}";
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
            }
        });


        $(document).on('click', '.update-business', function() {
            $('#upload_businessReqs_modal').modal('show');
            var update = "Update";
            $('#business_column_update').val(update);
            var data = $(this).data('business_req_update');
            if (data == "DTI") {
                $('#modal_title_business').html('Update DTI SEC Registration');
                $('#modal_add_submit_business').val('Edit DTI');
                $('#business_column').val('DTI');
            } else if (data == "LTO") {
                $('#modal_title_business').html('Update LTO Driving School Accreditation Permit');
                $('#modal_add_submit_business').val('Edit LTO Accreditation Permit');
                $('#business_column').val('LTO');
            } else if (data == "city_permit") {
                $('#modal_title_business').html('Update City/Municipality Permit');
                $('#modal_add_submit_business').val('Edit Permit');
                $('#business_column').val('city_permit');
            } else if (data == "BFP") {
                $('#modal_title_business').html('Update BFP Fire and Safety Permit');
                $('#modal_Edit_submit_business').val('Edit Permit');
                $('#business_column').val('BFP');
            }
            //alert(IDcolumn);
        });
    </script>
    @include(SchoolFileHelper::$footer)