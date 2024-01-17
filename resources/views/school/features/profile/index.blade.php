@include(SchoolFileHelper::$header, ['title' => 'Driving School Profile'])
<style>
    .nav-link {
        color: var(--primaryBG);
    }

    pre {
        white-space: pre-wrap;
        font-size: 16px;
        padding: 20px;

        text-align: justify;
        font-weight: 400;
    }
</style>
<div class="container-fluid" style="padding: 20px;margin-top:60px">

    <div class="row">
        <div class="col-4">
            <img style="height:200px;width:100%;object-fit: cover" src="/{{ $school->profile_image }}" alt=""
                srcset="">
            <h6 style="font-size: 18px;margin-top:20px">Name: {{ $school->name }}</h6>
            <h6 style="margin-top: 5px">Location: {{ $school->address }}</h6>
            {{-- <div style="width: 100%;height:200px;margin-top:10px" id="map">

            </div> --}}
        </div>
        <div class="col-lg-8">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                        type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">About</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"
                        type="button" role="tab" aria-controls="profile-tab-pane"
                        aria-selected="false">Policy</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane"
                        type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">My
                        reviews</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="openHours-tab" data-bs-toggle="tab"
                        data-bs-target="#openHours-tab-pane" type="button" role="tab"
                        aria-controls="openHours-tab-pane" aria-selected="false">Opening and Closing Hours
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent" style="margin-top: 20px">
                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                    tabindex="0">


                    @if (!isset($about->content))
                        <div style="width: 100%;margin-top:100px">
                            <center>
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#aboutAddForm">Write
                                    about</button>
                            </center>
                        </div>
                    @else
                        <pre>
@php
    echo $about->content;
@endphp
</pre>
                        <div style="width: 100%;margin-top:20px">

                            <button class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#updateAboutForm">Update
                                About</button>

                        </div>
                    @endif


                </div>
                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                    tabindex="0">
                    @if (!isset($terms->content))
                        <div style="width: 100%;margin-top:100px">
                            <center>
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">Write
                                    Policy</button>
                            </center>
                        </div>
                    @else
                        <pre>
@php
    echo $terms->content;
@endphp
</pre>
                        <div style="width: 100%;margin-top:20px">

                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updatePolicy">Update
                                Policy</button>

                        </div>
                    @endif
                </div>
                <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab"
                    tabindex="0">
                    My reviews</div>

                <div class="tab-pane fade" id="openHours-tab-pane" role="tabpanel" aria-labelledby="openHours-tab"
                    tabindex="0">
                    <div class="card border-secondary mb-2">
                        <div class="card-header bg-transparent border-dark">
                            <b>Open From:
                                @if ($openHours->type == 1)
                                    Monday - Saturday
                                @else
                                    Monday - Sunday
                                @endif
                            </b>
                        </div>
                        <div class="card-body text-secondary">
                            <h6><b>Opening Time:</b>
                                {{ Carbon\Carbon::createFromFormat('H:i:s', $openHours->opening_time)->format('g:i A') }}

                            </h6>
                            <h6><b>Closing Time:</b>
                                {{ Carbon\Carbon::createFromFormat('H:i:s', $openHours->closing_time)->format('g:i A') }}
                            </h6>
                        </div>


                        <button class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#updateOpeningHoursModal"> Update Opening and Closing Hours</button>

                    </div>


                </div>


            </div>
        </div>
    </div>

</div>
@if (isset($terms->content))
    <!-- update policy -->
    <div class="modal fade modal-lg" id="updatePolicy" tabindex="-1" aria-labelledby="updatePolicyLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updatePolicyLabel">Update policy</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form
                        action="{{ route('update.termsconditon', [
                            'id' => $terms->id,
                        ]) }}"
                        method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Policy</label>
                            <textarea name="content" required class="form-control" id="exampleFormControlTextarea1" rows="15">{{ $terms->content }}</textarea>
                        </div>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif


@if (isset($about->content))
    <div class="modal fade modal-lg" id="updateAboutForm" tabindex="-1" aria-labelledby="aboutAddFormLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update About</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding:25px">
                    <button type="button" class="btn-close" style="float: right" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                    <form
                        action="{{ route('update.updateAbout', [
                            'id' => $about->id,
                        ]) }}"
                        method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">About:</label>
                            <textarea name="content" placeholder="Enter about your driving school here..." required class="form-control"
                                id="exampleFormControlTextarea1" rows="15">{{ $about->content }}</textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
<!-- Modal -->
<div class="modal fade modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Policy</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('add.terms') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Policy:</label>
                        <textarea name="content" required class="form-control" id="exampleFormControlTextarea1" rows="15"></textarea>
                    </div>
                    <button class="btn btn-primary" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal fade modal-lg" id="aboutAddForm" tabindex="-1" aria-labelledby="aboutAddFormLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add About</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding:25px">
                <button type="button" class="btn-close" style="float: right" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <form action="{{ route('add.about') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">About:</label>
                        <textarea name="content" placeholder="Enter about your driving school here..." required class="form-control"
                            id="exampleFormControlTextarea1" rows="15"></textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- modal for openHours -->


<div class="modal fade" id="updateOpeningHoursModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Opening & Closing Hours</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    @csrf
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="openFrom" class="form-label">Open From: <i
                                                    id="check-openFrom" class="fa-solid fa-check check-label"
                                                    style=""></i></label>

                                            <select class='form-select mb-3' name="openFrom" required>
                                                <option value="1"
                                                    @if ($openHours->type == 1) selected @endif> Monday - Saturday
                                                </option>
                                                <option value="2"
                                                    @if ($openHours->type == 2) selected @endif>
                                                    Monday - Sunday
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="opening" class="form-label">Opening Time: <i
                                                    id="check-opening" class="fa-solid fa-check check-label"
                                                    style=""></i></label>
                                            <input type="time" class="form-control mb-3" name="opening"
                                                value="{{ substr($openHours->opening_time, 0, 5) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="closing" class="form-label">Closing Time: <i
                                                    id="check-closing" class="fa-solid fa-check check-label"
                                                    style=""></i></label>
                                            <input type="time" class="form-control mb-3" name="closing"
                                                value="{{ substr($openHours->closing_time, 0, 5) }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div style="padding:0 0 20px 0;">
                                    <div class="row justify-content-end">
                                        <div class="col-12">
                                            <input type="submit" class="btn-form" id="btn-update" value="Update">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>


@if (session('message'))
    <script>
        Toastify({
            text: "{{ session('message') }}",
            duration: 2000,

            gravity: "top", // `top` or `bottom`
            position: "center", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: "forestgreen",
            },
            onClick: function() {} // Callback after click
        }).showToast();
    </script>
@endif
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC85qXT_Yw5dwax9Rk9K62DLsxM9vVQWB4&callback=initMap&v=weekly"
    defer></script>
<script>
    let infoWindow;

    let map;



    function initMap() {
        const myLatlng = {
            lat: {
                {
                    $school - > latitude
                }
            },
            lng: {
                {
                    $school - > longitude
                }
            },
        };

        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 13,
            center: myLatlng,
        });

        // locationButton.addEventListener("click", () => {
        //     // if (navigator.geolocation) {
        //     //     navigator.geolocation.getCurrentPosition(
        //     //         async (position) => {
        //     //                 const pos = {
        //     //                     lat: position.coords.latitude,
        //     //                     lng: position.coords.longitude,
        //     //                 };
        //     //                 lat = pos.lat;
        //     //                 long = pos.lng;
        //     //                 await geocode({
        //     //                     location: pos
        //     //                 });
        //     //             },
        //     //             () => {
        //     //                 handleLocationError(true, infoWindow, map.getCenter());
        //     //             },
        //     //     );
        //     // } else {
        //     //     handleLocationError(false, infoWindow, map.getCenter());
        //     // }
        // });

    }

    window.initMap = initMap;

    $(document).ready(function() {
        $("#openHours_form").validate({
            highlight: function(element, errorClass, validClass) {
                $("#check-" + element.id).css('display', 'none');
            },
            unhighlight: function(element, errorClass, validClass) {
                $("#check-" + element.id).css('display', 'inline-block');
            },

            rules: {
                openFrom: {
                    required: true,
                },
                opening: {
                    required: true,
                },
                closing: {
                    required: true,
                },
            },
            messages: {
                openFrom: {
                    required: 'Open From option is required',
                },
                opening: {
                    required: 'Opening Time is required',
                },
                closing: {
                    required: 'Closing Time is required',
                },
            },

            submitHandler: function(form) {
                //form.submit();


                alert('hehe');
            }
        });

    });

    // let formHoursValidation = $("#openHours_form").validate({
    //     highlight: function(element, errorClass, validClass) {
    //         $("#check-" + element.name).css('display', 'none');
    //     },
    //     unhighlight: function(element, errorClass, validClass) {
    //         $("#check-" + element.name).css('display', 'inline-block');
    //     },
    //     rules: {
    //         openFrom: {
    //             required: true,
    //         },
    //         opening: {
    //             required: true,
    //         },
    //         closing: {
    //             required: true,
    //         },


    //     },
    //     messages: {
    //         openFrom: {
    //             required: 'Open From option is required',
    //         },
    //         opening: {
    //             required: 'Opening Time is required',
    //         },
    //         closing: {
    //             required: 'Closing Time is required',
    //         },

    //     },
    //     submitHandler: function(form) {
    //         alert('hehe');

    //     }
    // });


    $('#filterbutton').click(function() {
        var closing = $('#closing').val();
        var opening = $("#opening").val();
        var openFrom = $("#openFrom").val();

        alert('hehehhe');
    });
</script>
@include(SchoolFileHelper::$footer)
