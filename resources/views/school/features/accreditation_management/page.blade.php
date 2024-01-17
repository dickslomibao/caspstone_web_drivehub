<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Accrediation Application</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel="stylesheet" href="{{ asset('css/static.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap5.2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/data_table_bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/messages.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- for file export -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <!-- ending----- for file export -->


    <script src="{{ asset('js/jq.js') }}"></script>
    <script src="{{ asset('js/bootstrap5.2.js') }}"></script>
    <script src="{{ asset('js/data_table.js') }}"></script>
    <script src="{{ asset('js/data_table_bootstrap.js') }}"></script>
    <script src="{{ asset('js/moment.js') }}"></script>

    <!-- for file export -->
    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <!-- ending -----for file export -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro@4cac1a6/css/all.css" rel="stylesheet"
        type="text/css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link rel="stylesheet" href="{{ asset('css/sidenav.css') }}">






    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



    <!-- <script src="{{ asset('jsExportFile/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('jsExportFile/buttons.print.min.js') }}"></script>
    <script src="{{ asset('jsExportFile/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('jsExportFile/jquery-3.7.0.js') }}"></script>
    <script src="{{ asset('jsExportFile/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('jsExportFile/jszip.min.js') }}"></script>
    <script src="{{ asset('jsExportFile/pdfmake.min.js') }}"></script>
    <script src="{{ asset('jsExportFile/vfs_fonts.js') }}"></script> -->



    <script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    const user_current_id = "{{ Auth::user()->schoolid }}";
    var pusher = new Pusher('40178e8c6a9375e09f5c', {
        cluster: 'ap1',
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                "_token": "{{ csrf_token() }}",
            }
        }
    });
    </script>
</head>

<body>
    @php
    $statusString = ($status->accreditation_status == 1)
    ? '<span class="waiting">Pending</span>'
    : '<span class="completed">Approved</span>';


    $application_percent = 0;
    $percent = 0;

    if($firstValidID[0]->validID1 != ""){
    $application_percent ++;
    }

    if($firstValidID[0]->validID2 != ""){
    $application_percent ++;
    }

    if($firstValidID[0]->DTI != ""){
    $application_percent ++;
    }

    if($firstValidID[0]->LTO != ""){
    $application_percent ++;
    }

    if($firstValidID[0]->city_permit != ""){
    $application_percent ++;
    }

    if($firstValidID[0]->BFP != ""){
    $application_percent ++;
    }


    $percent = ($application_percent/6) * 100;
    $total = number_format($percent, 2);

    $minus = (100-$total);


    @endphp

    <div class="card border">

        <div class="row">

            <div class="col-sm-6 text-end">
                <div class="d-flex align-items-left justify-content-left top">
                    <div class="logo">
                        <img src="/logo1.png" alt="" width="30" height="30">
                        <h4 class="text-logo"></h4>
                    </div>
                    <h5 id="text-logo">Drive <span class="d">Hub</span></h5>
                </div>



            </div>

            <div class="col-sm-6 text-end">

                <img src="https://media.sproutsocial.com/uploads/2022/06/profile-picture.jpeg" class="rounded-circle"
                    style="width: 30px;height:30px" alt="Avatar" />

                @auth
                @if (Auth::user()->type == 1)
                {{ Auth::user()->info->name }}
                @endif
                @if (Auth::user()->type == 4)
                {{ Auth::user()->info->firstname }} {{ Auth::user()->info->lastname }}
                @endif
                @endauth

            </div>
        </div>
    </div>

    @if($application_percent==6)
    <br>
    <div class="alert alert-success" style="margin-left: 10px; margin-right: 10px;">
        <center><b>The document verification process typically takes 2-3 business days.
                You will be notified of the status of your application after the verification process is complete
                through E-Mail.</b>
        </center>
    </div>

    @endif

    <div class="container-fluid" style="padding: 20px;margin-top:10px">
        <div class="card">



            <center>
                <h4><b>Drivehub Accreditation Process</b></h4>
            </center>


            <p style="text-align: justify;">
                The Drivehub accreditation process for driving schools ensures a thorough review to maintain high
                standards. Upon submitting the online application with accurate business details, schools meeting
                criteria undergo a meticulous document verification process, including licenses and certifications.
                Accreditation approval is granted upon successful document verification, emphasizing compliance with
                local regulations and a positive reputation. </p>
            <p style="text-align: justify;">
                At Drivehub, we prioritize safety and quality, and we appreciate your interest in joining our platform.
                To ensure a seamless onboarding experience, please follow the accreditation process outlined <span
                    style="color: blue;"> <a href="#" class="dropdown-item process">here.</a></span>

            </p>
        </div>
    </div>






    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Drivehub Accreditation Process for Driving
                        Schools</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-11 mx-auto">
                        <ol>
                            <li><b>1. Document Submission:</b> <br>

                                <p style="text-align: justify;">&#8226 After successful registration, you will be
                                    required to submit necessary documents
                                    for
                                    verification.
                                    Required documents may include business licenses, instructor certifications, and
                                    other
                                    relevant credentials.</p>
                            </li>
                            <li><b>2. Document Verification:</b> <br>

                                <p style="text-align: justify;">&#8226 Our team will carefully verify the submitted
                                    documents to ensure compliance with our standards.
                                    Prompt and accurate document submission is crucial for a smooth verification
                                    process.</p>
                            </li>

                            <li><b>3. Accreditation Approval:</b> <br>

                                <p style="text-align: justify;">&#8226 Upon successful verification of your documents,
                                    you will receive an approval notification (Email).
                                    Accredited driving schools must comply with all local regulations and maintain a
                                    positive reputation.</p>
                            </li>
                            <li><b>4. Processing Time:</b> <br>

                                <p style="text-align: justify;">&#8226 The document verification process typically takes
                                    2-3 business days.
                                    You will be notified of the status of your application after the verification
                                    process is complete. through E-mail</p>
                            </li>
                            <li><b>5. System Access:</b> <br>

                                <p style="text-align: justify;">&#8226 Upon successful verification and approval, your
                                    driving school will gain access to the Drivehub system.
                                    You can start utilizing the platform to connect with students and manage your
                                    driving school services.</p>
                            </li>
                        </ol>

                        <br>

                        Drivehub values transparency and efficiency throughout the accreditation process. If you have
                        any questions or need assistance, please contact our support team at support@drivehub.com.
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div>






    <div class="container-fluid" style="padding: 20px;">
        <div class="row">
            <div class="col-12">
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

                            <div class="col-sm-11 mx-auto">
                                <ul>
                                    <li>&#8226 Employee’s ID / Office ID</li>
                                    <li>&#8226 Registration Form Philippine Identification (PhilID / ePhilID)</li>
                                    <li>&#8226 NBI Clearance*</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <p><b> b). </b> Business Documents Requirements for Accreditation of Driving School:</p>
                            <div class="col-sm-11 mx-auto">
                                <ul>
                                    <li>&#8226 DTI SEC Registration</li>
                                    <li>&#8226 LTO Driving School Accreditation Permit</li>
                                    <li>&#8226 City/Municipality Permit</li>
                                    <li>&#8226 BFP Fire and Safety Permit</li>
                                </ul>
                            </div>
                        </div>
                    </div>




                </div>

                <div class="card" style="margin: 10px 0 20px 0">



                    <div class="col-lg-3 mx-auto">
                        <center>
                            <h5>Application Progress</h5>

                            <canvas id="applicationChart" style="width:100%;max-width:500px"></canvas>
                        </center>
                    </div>
                    <br>

                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                                aria-selected="true">Identification Card</button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                                aria-selected="false">Business
                                Documents Requirements</button>
                        </div>
                    </nav>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                            aria-labelledby="nav-home-tab" tabindex="0">
                            <!-- start  of  Identification  -->

                            <div class="col mt-3">

                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-home" type="button" role="tab"
                                            aria-controls="pills-home" aria-selected="true">First Valid ID</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-profile" type="button" role="tab"
                                            aria-controls="pills-profile" aria-selected="false">Second Valid ID</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                        aria-labelledby="pills-home-tab" tabindex="0">



                                        @if($datarow == "None")

                                        <div class="alert alert-danger col-11 mx-auto">
                                            <center>
                                                <h6>No valid ID has been uploaded yet.</h6>
                                            </center>
                                        </div>
                                        <center> <span style="color: blue;"><a href="#"
                                                    class="dropdown-item upload-ValidID" data-id_no="validID1">Upload
                                                    Now</a></center> </span>

                                        @else

                                        @php



                                        $stringType= "";
                                        if($firstValidID[0]->ID1_type == 1){
                                        $stringType= "Employee’s ID / Office ID";
                                        }else if($firstValidID[0]->ID1_type == 2){
                                        $stringType= "Registration Form Philippine Identification (PhilID /
                                        ePhilID)";
                                        }else if($firstValidID[0]->ID1_type == 3){
                                        $stringType= "NBI Clerance";
                                        }

                                        @endphp

                                        <div class="col-11 mx-auto">
                                            <b>Type of Identification Card: </b> {{$stringType}}
                                        </div>
                                        <div id="pdfContainer" class="col-11 mx-auto">
                                            <object data="/{{$firstValidID[0]->validID1}}" type="application/pdf"
                                                width="100%" height="500">
                                            </object>
                                            If you are unable to view the PDF, you can <a
                                                href="/{{$firstValidID[0]->validID1}}">download
                                                it
                                                here</a>.
                                        </div>
                                        @endif

                                        <br>
                                    </div>
                                    <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                        aria-labelledby="pills-profile-tab" tabindex="0">



                                        @if($checkvalidID2 == "None")

                                        <div class="alert alert-danger col-11 mx-auto">
                                            <center>
                                                <h6>No valid ID has been uploaded yet.</h6>
                                            </center>
                                        </div>
                                        <center> <span style="color: blue;"><a href="#"
                                                    class="dropdown-item upload-ValidID" data-id_no="validID2">Upload
                                                    Now</a></center> </span>

                                        @else


                                        @php



                                        $stringType= "";
                                        if($firstValidID[0]->ID2_type == 1){
                                        $stringType= "Employee’s ID / Office ID";
                                        }else if($firstValidID[0]->ID2_type == 2){
                                        $stringType= "Registration Form Philippine Identification (PhilID /
                                        ePhilID)";
                                        }else if($firstValidID[0]->ID2_type == 3){
                                        $stringType= "NBI Clerance";
                                        }

                                        @endphp

                                        <div class="col-11 mx-auto">
                                            <b>Type of Identification Card: </b> {{$stringType}}
                                        </div>

                                        <div id="pdfContainer" class="col-11 mx-auto">
                                            <object data="/{{$firstValidID[0]->validID2}}" type="application/pdf"
                                                width="100%" height="500">
                                            </object>
                                            If you are unable to view the PDF, you can <a
                                                href="/{{$firstValidID[0]->validID2}}">download
                                                it
                                                here</a>.
                                        </div>
                                        @endif

                                        <br>


                                    </div>

                                </div>
                            </div>

                            <!-- end of  Identification  -->
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"
                            tabindex="0">
                            <!-- start  of  business  -->

                            <div class="col mt-3">

                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pills-dti-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-dti" type="button" role="tab"
                                            aria-controls="pills-dti" aria-selected="true">DTI SEC Registration</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-lto-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-lto" type="button" role="tab"
                                            aria-controls="pills-lto" aria-selected="false">LTO Driving School
                                            Accreditation Permit</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-city-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-city" type="button" role="tab"
                                            aria-controls="pills-city" aria-selected="false">City/Municipality
                                            Permit</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-bfp-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-bfp" type="button" role="tab"
                                            aria-controls="pills-bfp" aria-selected="true">BFP Fire and Safety
                                            Permit</button>
                                    </li>

                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-dti" role="tabpanel"
                                        aria-labelledby="pills-dti-tab" tabindex="0">


                                        @if($checkDTI == "None")

                                        <div class="alert alert-danger col-11 mx-auto">
                                            <center>
                                                <h6>No DTI SEC Registration has been uploaded yet.</h6>
                                            </center>
                                        </div>
                                        <center> <span style="color: blue;"><a href="#"
                                                    class="dropdown-item upload-business" data-business_req="DTI">Upload
                                                    Now</a></center> </span>

                                        @else



                                        <div id="pdfContainer" class="col-11 mx-auto">
                                            <object data="/{{$firstValidID[0]->DTI}}" type="application/pdf"
                                                width="100%" height="500">
                                            </object>
                                            If you are unable to view the PDF, you can <a
                                                href="/{{$firstValidID[0]->DTI}}">download
                                                it
                                                here</a>.
                                        </div>
                                        @endif

                                        <br>


                                    </div>
                                    <div class="tab-pane fade" id="pills-lto" role="tabpanel"
                                        aria-labelledby="pills-lto-tab" tabindex="0">

                                        @if($checkLTO == "None")

                                        <div class="alert alert-danger col-11 mx-auto">
                                            <center>
                                                <h6>No LTO Driving School Accreditation Permit has been uploaded yet.
                                                </h6>
                                            </center>
                                        </div>
                                        <center> <span style="color: blue;"><a href="#"
                                                    class="dropdown-item upload-business" data-business_req="LTO">Upload
                                                    Now</a></center> </span>

                                        @else



                                        <div id="pdfContainer" class="col-11 mx-auto">
                                            <object data="/{{$firstValidID[0]->LTO}}" type="application/pdf"
                                                width="100%" height="500">
                                            </object>
                                            If you are unable to view the PDF, you can <a
                                                href="/{{$firstValidID[0]->LTO}}">download
                                                it
                                                here</a>.
                                        </div>
                                        @endif

                                        <br>

                                    </div>
                                    <div class="tab-pane fade" id="pills-city" role="tabpanel"
                                        aria-labelledby="pills-city-tab" tabindex="0">



                                        @if($checkcity == "None")

                                        <div class="alert alert-danger col-11 mx-auto">
                                            <center>
                                                <h6>No City/Municipality Permit has been uploaded yet.</h6>
                                            </center>
                                        </div>
                                        <center> <span style="color: blue;"><a href="#"
                                                    class="dropdown-item upload-business"
                                                    data-business_req="city_permit">Upload
                                                    Now</a></center> </span>

                                        @else



                                        <div id="pdfContainer" class="col-11 mx-auto">
                                            <object data="/{{$firstValidID[0]->city_permit}}" type="application/pdf"
                                                width="100%" height="500">
                                            </object>
                                            If you are unable to view the PDF, you can <a
                                                href="/{{$firstValidID[0]->city_permit}}">download
                                                it
                                                here</a>.
                                        </div>
                                        @endif

                                        <br>

                                    </div>
                                    <div class="tab-pane fade show" id="pills-bfp" role="tabpanel"
                                        aria-labelledby="pills-bfp-tab" tabindex="0">



                                        @if($checkBFP == "None")

                                        <div class="alert alert-danger col-11 mx-auto">
                                            <center>
                                                <h6>No BFP Fire and Safety Permit has been uploaded yet.</h6>
                                            </center>
                                        </div>
                                        <center> <span style="color: blue;"><a href="#"
                                                    class="dropdown-item upload-business" data-business_req="BFP">Upload
                                                    Now</a></center> </span>

                                        @else



                                        <div id="pdfContainer" class="col-11 mx-auto">
                                            <object data="/{{$firstValidID[0]->BFP}}" type="application/pdf"
                                                width="100%" height="500">
                                            </object>
                                            If you are unable to view the PDF, you can <a
                                                href="/{{$firstValidID[0]->BFP}}">download
                                                it
                                                here</a>.
                                        </div>
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




    <div class="modal fade" id="upload_validID_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                                                    Identification Cards: <i id="check-acceptable"
                                                        class="fa-solid fa-check check-label" style=""></i></label>
                                                <select class="form-select" name="acceptable" id="acceptable"
                                                    aria-label="Default select example" required>
                                                    <option value="1">Employee’s ID / Office ID</option>
                                                    <option value="2">Registration Form Philippine Identification
                                                        (PhilID /
                                                        ePhilID)</option>
                                                    <option value="3">NBI Clerance</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="pdfFile" class="form-label">Valid Identification Card: <i
                                                        id="check-pdfFile" class="fa-solid fa-check check-label"
                                                        style=""></i></label>
                                                <input type="file" class="form-control" name="pdfFile" id="pdfFile"
                                                    accept=".pdf">
                                                <input type="hidden" class="form-control" name="idColumn" id="idColumn"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="padding:0 0 20px 0;">
                                        <div class="row justify-content-end">
                                            <div class="col-12">
                                                <input type="submit" class="btn-form" id="modal_add_submit"
                                                    value="Add Privacy Policy">
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



    <div class="modal fade" id="upload_businessReqs_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                                                <label for="pdfFile" class="form-label">Business Requirement: <i
                                                        id="check-pdfFile_business"
                                                        class="fa-solid fa-check check-label" style=""></i></label>
                                                <input type="file" class="form-control" name="pdfFile_business"
                                                    id="pdfFile_business" accept=".pdf">
                                                <input type="hidden" class="form-control" name="business_column"
                                                    id="business_column" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="padding:0 0 20px 0;">
                                        <div class="row justify-content-end">
                                            <div class="col-12">
                                                <input type="submit" class="btn-form" id="modal_add_submit_business"
                                                    value="Add Privacy Policy">
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

    $(document).on('click', '.process', function() {
        $('#staticBackdrop').modal('show');

    });



    $(document).on('click', '.upload-business', function() {
        $('#upload_businessReqs_modal').modal('show');
        // $('#modal_title_business').html('Update Progress');
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

    var xValues = ["Passed", "Pending"];
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

            },
        },
        messages: {
            acceptable: {
                required: "Type of Government-Issued Identification Card is required",
            },
            pdfFile: {
                required: "Pdf File is required",

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

            },
        },
        messages: {
            pdfFile_business: {
                required: "Pdf File is required",
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
    </script>

    @include(SchoolFileHelper::$footer)