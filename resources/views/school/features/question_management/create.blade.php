@include(SchoolFileHelper::$header, ['title' => 'Create a question'])
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

            <form action="" method="post" id="question-form" enctype="multipart/form-data">
                @csrf
                <div class="col-12">
                    <h6 style="margin: 15px 0">Question Information</h6>
                </div>
                <div class="card" style="">

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="question" class="form-label">Question:</label>
                                <textarea class="form-control" name="question" id="question" rows="3" placeholder="Enter question here..."></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status: <i id="check-status"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <select class="form-select" name="status" id="status"
                                    aria-label="Default select example" required>

                                    <option value="1" selected>Available</option>
                                    <option value="0">Not available</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="images" class="form-label">Select image (if necessary): <i
                                        id="check-images" class="fa-solid fa-check check-label"
                                        style=""></i></label>
                                <input type="file" class="form-control" accept="image/*" id="images" name="images" />
                            </div>
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
                                <input type="radio" name="answer" value="1" class="form-check-input"
                                    style="margin-right:5px">
                                <label for="c1" class="form-label">A: <i id="check-c1"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="text" class="form-control" id="c1" name="choices[]" required />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <input type="radio" name="answer" value="2" class="form-check-input"
                                    style="margin-right:5px">
                                <label for="c2" class="form-label">B: <i id="check-c2"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="text" class="form-control" id="c2" name="choices[]" required />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <input type="radio" name="answer" value="3" class="form-check-input"
                                    style="margin-right:5px">
                                <label for="c3" class="form-label">C: <i id="check-c3"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="text" class="form-control" id="c3" name="choices[]" required />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12 d-flex align-items-center justify-content-end">
                        <button type="submit" id="btn-submit">Add Question</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        $("#question-form").validate({
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
                    textOnly: "Firstname is invalid"
                },

            },
            submitHandler: function(form) {
                if ($('input[type="radio"]:checked').length <= 0) {
                  
                    alert('Please select answer');
                    return;
                }
                form.submit();
                // $.ajax({
                //     type: "POST",
                //     url: "{{ route('store.question') }}",
                //     contentType: false,
                //     processData: false,
                //     data: new FormData(form),
                //     success: function(response) {
                //         // if (response.code == 200) {

                //         // }
                //         console.log(response);
                //     }
                // });
            }
        });
    });
</script>
@include(SchoolFileHelper::$footer)
