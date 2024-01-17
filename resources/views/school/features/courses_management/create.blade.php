@include(SchoolFileHelper::$header, ['title' => 'Create a new course'])
<style>
    .btn-add-course {
        margin-top: 10px;
        padding: 0 50px;
        height: 44px;
        background: var(--secondaryBG);
        color: white;
        border: none;
        outline: none;
        font-size: 16px;
        font-weight: 500;
        border-radius: 10px;
    }
</style>
<div class="container-fluid" style="padding: 20px;margin-top:60px">

    <form id="courseForm" action="" method="POST" enctype="multipart/form-data">
        <h6 style="margin-bottom:15px">Course details:</h6>
        <div class="card" style="margin: 10px 0 20px 0">
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="type" value="2"
                                id="check-theory">
                            <label class="form-check-label" for="">
                                Check if theoretical course
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="name" class="form-label">Course name: <i id="check-name"
                                class="fa-solid fa-check check-label" style=""></i></label>
                        <div>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter course name..." required />
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status: <i id="check-status"
                                class="fa-solid fa-check check-label" style=""></i></label>
                        <select class="form-select" required name="status" id="status"
                            aria-label="Default select example" required>
                            <option value="1" selected>Available</option>
                            <option value="2">Not available</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="visibility" class="form-label">Visibility: <i id="check-visibility"
                                class="fa-solid fa-check check-label" style=""></i></label>
                        <select class="form-select" required name="visibility" id="visibility"
                            aria-label="Default select example" required>
                            <option value="1" selected>Show to public</option>
                            <option value="2">Hide to public</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12" style="display: none" id="c-price">
                    <div class="mb-3">
                        <label for="price" class="form-label">Course price:</label>
                        <div>
                            <input type="number" class="form-control" name="price" id="price"
                                placeholder="Enter course price..." />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="c-list">
            <i id="check-progress" class="fa-solid fa-check check-label" style=""></i>
            <div style="margin-bottom:15px" class="d-flex align-items-center justify-content-between">
                <h6>Course Vehicle:</h6>
                {{-- <a role="button" style="color: var(--primaryBG);font-weight:500;font-size:15px;">Advance</a> --}}
            </div>

            <div class="" style="margin: 10px 0 20px 0">
                <div class="row">
                    @foreach ($vehicles as $vehicle)
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="vehicles[]"
                                            value="{{ $vehicle->id }}" id="">

                                    </div>
                                    <h6 style="font-size: 15px;line-height:20px">Name:
                                        {{ $vehicle->name }}</h6>
                                    <h6 style="font-size: 15px;line-height:20px">Type:
                                        {{ $vehicle->type }}</h6>
                                    <h6 style="font-size: 15px;line-height:20px">Plate Number:
                                        {{ $vehicle->plate_number }}</h6>

                                    <h6 style="font-size: 15px;line-height:20px">Transmission:
                                        {{ $vehicle->transmission }}</h6>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="col-12">

                    </div>
                </div>
            </div>
        </div>
        <h6 style="margin-bottom:15px">Additional information:</h6>
        <div class="card" style="margin: 10px 0 20px 0">
            <div class="col-12">
                <div class="mb-3">
                    <label for="description" class="form-label">Course Description: <i id="check-description"
                            class="fa-solid fa-check check-label" style=""></i></label>
                    <div>
                        <textarea name="description" class="form-control" id="description" rows="5" required></textarea>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="price" class="form-label">Course thumbnail: <i id="check-image"
                            class="fa-solid fa-check check-label" style=""></i></label>
                    <div>
                        <input type="file" class="form-control" name="image" id="image" id="image"
                            required />
                    </div>
                </div>
            </div>
        </div>
        <div id="p-list">
            <i id="check-progress" class="fa-solid fa-check check-label" style=""></i>
            <h6 style="margin-bottom:15px">Course Progress:</h6>
            <div class="card" style="margin: 10px 0 20px 0">
                <div class="row">
                    @foreach ($progress as $data)
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="progress[]"
                                        value="{{ $data->id }}" id="">
                                    <label class="form-check-label" for="">
                                        {{ $data->title }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
            <div class="d-flex align-items-center justify-content-end"  style="margin: 10px 10px 0 0">
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="" id="all">
                        <label class="form-check-label" for="">
                            Check all
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end" style="margin-top:20px">
            <button class="btn-add-course">Add Course</button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        $('#all').change(function() {
            if (this.checked) {
                $('input[name="progress[]"]').prop('checked',true);
            } else {
                $('input[name="progress[]"]').prop('checked',false);
            }
        });
        $('#check-theory').change(function() {
            if (this.checked) {
                $('#p-list').css('display', 'none');
                $('#c-list').css('display', 'none');
                $('#c-price').css('display', 'block');
            } else {
                $('#c-list').css('display', 'block');
                $('#p-list').css('display', 'block');
                $('#c-price').css('display', 'none');
            }
        });


        $("#courseForm").validate({
            highlight: function(element, errorClass, validClass) {
                $("#check-" + element.id).css('display', 'none');
            },
            unhighlight: function(element, errorClass, validClass) {
                $("#check-" + element.id).css('display', 'inline-block');
            },
            rules: {
                name: {
                    required: true,

                },
                status: {
                    required: true,

                },
                visibility: {
                    required: true,

                },
                description: {
                    required: true,
                },

            },
            messages: {
                name: {
                    required: "Course name is required",
                    textOnly: "Course name is invalid"
                },
                status: {
                    required: "Status is required",

                },
                visibility: {
                    required: "Visibility is required",
                },
                description: {
                    required: "Description name is required",
                    textOnly: "Description name is invalid"
                },
            },
            submitHandler: function(form) {
                let price = $("#price").val();
                if ($('#check-theory').is(':checked')) {
                    if (price == "") {
                        alert('Price is required');
                        return;
                    }
                } else {
                    if ($('input[name="progress[]"]:checked').length == 0) {
                        alert('Select atleast one progress');
                        return;
                    }
                    if ($('input[name="vehicles[]"]:checked').length == 0) {
                        alert('Select atleast vehicles of the course');
                        return;
                    }
                }
                $.ajax({
                    type: "POST",
                    url: "{{ route('storeFromWeb.course') }}",
                    contentType: false,
                    processData: false,
                    data: new FormData(form),
                    success: function(response) {
                        console.log(response);
                        if (response.code == 200) {
                            swal({
                                icon: "success",
                                title: 'Course Successfully Added',
                                text: " ",
                                timer: 2000,
                                showConfirmButton: false,
                            }).then(function() {
                                window.location.href =
                                    "{{ route('index.courses') }}";
                            });
                        }
                    }
                });

            }
        });
    });
</script>



@include(SchoolFileHelper::$footer)
