@include(SchoolFileHelper::$header, ['title' => 'Update question'])
<style>
    .button-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center
    }

    button {
        background-color: var(--secondaryBG);
        border: none;
        color: #fff;
        width: 200px;
        padding: 0 20px;
        height: 40px;
        font-size: 15px;
        border-radius: 5px;
    }
</style>
<div class="container-fluid" style="padding: 20px;margin-top:60px">
    <div class="row">
        <div class="col-12">

            <form action="" method="post" id="update-question-form" enctype="multipart/form-data">
                @csrf
                <div class="col-12">
                    <h6 style="margin: 15px 0">Question Information</h6>
                </div>
                <div class="card" style="">

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="question" class="form-label">Question:</label>
                                <textarea class="form-control" name="question" id="question" rows="3" placeholder="Enter question here..."> {{ $details->questions }}</textarea>
                            </div>
                        </div> 
                        <input type="text" name="question_id" value="{{ $details->id }}" hidden>
                        <div class="col-12">
                            <div class="mb-3">
                                @if ($details->images !== '' || $details->images !== null)
                                    <label class="form-label">Initial Image:</label>
                                    <div class="col-4 mx-auto">
                                        <img class="img-fluid" style="border-radius: 10px" src="/{{ $details->images }}"
                                            alt="" srcset="">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">

                            <div class="mb-3">
                                <label for="status" class="form-label">Status: <i id="check-status"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <select class="form-select" name="status" id="status"
                                    aria-label="Default select example" required>

                                    <option value="1" {{ $details->status == 1 ? 'selected' : '' }}>Available
                                    </option>
                                    <option value="0" {{ $details->status == 0 ? 'selected' : '' }}>Not
                                        available
                                    </option>
                                </select>
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <label for="images" class="form-label">Select image (if necessary): <i id="check-images"
                                    class="fa-solid fa-check check-label" style=""></i></label>
                            <input type="file" class="form-control" id="images" name="images" />
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <h6 style="margin: 15px 0">Question choices</h6>
                </div>
                <div class="card" style="padding: 20px">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <input type="radio" name="answer" value="1"
                                    {{ $details->answer == 1 ? 'checked' : '' }} class="form-check-input"
                                    style="margin-right:5px">
                                <label for="c1" class="form-label">A: <i id="check-c1"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="text" class="form-control" id="c1" name="choices[]" required
                                    value="{{ $choices[0]->body }}" />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <input type="radio" name="answer" value="2"
                                    {{ $details->answer == 2 ? 'checked' : '' }} class="form-check-input"
                                    style="margin-right:5px">
                                <label for="c2" class="form-label">B: <i id="check-c2"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="text" class="form-control" id="c2" name="choices[]" required
                                    value="{{ $choices[1]->body }}" />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <input type="radio" name="answer" value="3"
                                    {{ $details->answer == 3 ? 'checked' : '' }} class="form-check-input"
                                    style="margin-right:5px">
                                <label for="c3" class="form-label">C: <i id="check-c3"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="text" class="form-control" id="c3" name="choices[]" required
                                    value="{{ $choices[2]->body }}" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12 d-flex align-items-center justify-content-end">
                        <button type="submit" id="btn-submit">Update Question</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        $("#update-question-form").validate({
            highlight: function(element, errorClass, validClass) {
                $("#check-" + element.id).css('display', 'none');
            },
            unhighlight: function(element, errorClass, validClass) {
                $("#check-" + element.id).css('display', 'inline-block');
            },
            rules: {
                question: {
                    required: true,
                },
            },
            messages: {
                question: {
                    required: "Question is required",
                    textOnly: "Question is invalid"
                },

            },
            submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('update.question') }}",
                    contentType: false,
                    processData: false,
                    data: new FormData(form),
                    success: function(response) {
                        console.log(response);
                        if (response.code == 200) {
                            swal({
                                icon: "success",
                                title: 'Question Successfully Updated',
                                text: " ",
                                timer: 2000,
                                showConfirmButton: false,
                            }).then(function() {
                                window.location.href =
                                    "{{ route('index.question') }}";
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
    });
</script>
@include(SchoolFileHelper::$footer)
