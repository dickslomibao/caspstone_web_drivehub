@include(SchoolFileHelper::$header, ['title' => 'Update Course'])
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
    <form id="courseForm" action="" method="POST" enctype="multipart/form-data"> @csrf

        <div class=" row">
            {{-- <div class="col-lg-2">
                <div class="col-12" style="margin:10px 0 30px 0">
                    <h6>Course Thumbnail</h6>
                </div> <img class="img-fluid" style="border-radius: 10px" src="/{{($details->thumbnail)}}" alt=""
                    srcset="">
                <div class="mb-3" style="margin-top: 30px">
                    <input type="file" class="form-control" name="image" />
                </div>
            </div> --}}
            <div class="col-lg-12">
                <h6 style="margin:10px 0 0 0">Course details:</h6>
                <div class="card" style="margin: 10px 0 20px 0">
                    <div class="row">
                        {{-- <div class="col-12">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" disabled type="checkbox" name="type"
                                        {{ $details->type == 2 ? 'checked' : '' }} value="2" id="">
                                    <label class="form-check-label" for="">
                                        Check if theoretical course
                                    </label>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-lg-4">
                            <div class="mb-3"> <label for="name" class="form-label">Course name: <i
                                        id="check-name" class="fa-solid fa-check check-label"
                                        style=""></i></label>
                                <div>
                                    <input type="text" class="form-control" name="name" id="name"
                                        placeholder="Enter course name..." required value="{{ $details->name }}" />
                                    <input type="hidden" class="form-control" name="course_id" id="course_id" required
                                        value="{{ $details->id }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status: <i id="check-status"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <select class="form-select" name="status" id="status"
                                    aria-label="Default select example" required>
                                    <option value="1" {{ $details->status == '1' ? 'selected' : '' }}>Available
                                    </option>
                                    <option value="2" {{ $details->status == '2' ? 'selected' : '' }}>Not available
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="status" class="form-label">Visibility: <i id="check-visibility"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <select class="form-select" name="visibility" id="visibility"
                                    aria-label="Default select example" required>
                                    <option value="1" {{ $details->visibility == '1' ? 'selected' : '' }}>Show to
                                        public
                                    </option>
                                    <option value="2" {{ $details->visibility == '2' ? 'selected' : '' }}>Hide to
                                        public
                                    </option>
                                </select>
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
                                <textarea name="description" class="form-control" id="description" required> {{ $details->description }} </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Course images: <i id="check-image"
                                class="fa-solid fa-check check-label" style=""></i></label>
                        <input type="file" class="form-control" accept="image/*" name="image" id="image" />
                    </div>
                </div>
                @if ($details->type == 1)

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
                                                        value="{{ $vehicle->id }}"
                                                        {{ in_array($vehicle->id, $c_v) ? 'checked' : '' }}
                                                        id="">
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
                    <h6 style="margin-bottom:15px">Course Progress:</h6>
                    <div class="card">
                        <i id="check-progress" class="fa-solid fa-check check-label" style=""></i>
                        <div class="row">
                            @foreach ($progress as $data)
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="progress[]"
                                                value="{{ $data->id }}" id="{{ $data->id }}"
                                                {{ collect($course_progress)->contains('progress_id', $data->id) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="{{ $data->id }}">
                                                {{ $data->title }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button class="btn-add">Update Course</button>
        </div>
    </form>
</div>





<script>
    $(document).ready(function() {
        $.validator.addMethod("textOnly", function(value, element) {
            return value.trim().match(/^[A-Za-z ]+$/);
        });
        $.validator.addMethod("atLeastOneChecked", function(value, element) {
            return $('input[name="progress[]"]:checked').length > 0;
        }, "Please select at least one progress checkbox.");
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

                let type = {{ $details->type }};
                if (type == 1) {
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
                    url: "{{ route('updateFromWeb.course') }}",
                    contentType: false,
                    processData: false,
                    data: new FormData(form),
                    success: function(response) {
                        console.log(response);
                        if (response.code == 200) {
                            swal({
                                icon: "success",
                                title: 'Course Successfully Updated',
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
