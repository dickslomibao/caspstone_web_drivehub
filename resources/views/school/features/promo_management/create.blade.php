@include(SchoolFileHelper::$header, ['title' => 'Create a promo'])

<div class="container-fluid" style="padding: 20px;margin-top:60px">
    <div class="row">
        <div class="col-12">
            <form method="post" id="form-promo" enctype="multipart/form-data">
                @csrf

                <h6 style="margin-bottom:15px">Promo details:</h6>


                <div class="card" style="margin: 10px 0 20px 0">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="title" class="form-label">Name: <i id="check-title"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="text" class="form-control" id="title" name="name"
                                    placeholder="Enter title..." required />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Price: <i id="check-price"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="number" class="form-control" id="price" name="price"
                                    placeholder="Enter price..." required />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start date: <i id="check-start_date"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="datetime-local" class="form-control"min="{{ now()->format('Y-m-d\TH:i') }}"
                                    id="start_date" name="start_date" placeholder="Enter start date..." required />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End date: <i id="check-end_date"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="datetime-local" class="form-control"min="{{ now()->format('Y-m-d\TH:i') }}"
                                    id="end_date" name="end_date" placeholder="Enter end date..." required />
                            </div>
                        </div>
                    </div>
                </div>

                <h6 style="margin-bottom:15px">Promo Items:</h6>

                <div class="card" style="margin: 10px 0 20px 0">
                    <div class="row">
                        @foreach ($school_courses as $course)
                            @if (count($course->variants) == 0)
                                @php
                                    continue;
                                @endphp
                            @endif
                            <div class="col-lg-6">
                                <div style="padding:10px;border:1px solid var(--borderColor);margin-bottom:15px;">
                                    <h6 style="margin-bottom: 10px">{{ $course->name }}</h6>
                                    <div class="row">
                                        @foreach ($course->variants as $variant)
                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" value="{{ $variant->id }}"
                                                        type="radio" name="{{ $course->id }}"
                                                        id="{{ $course->id }}">
                                                    <label class="form-check-label" for="{{ $course->id }}">
                                                        {{ $variant->duration }} hrs (Php {{ $variant->price }})
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="d-flex justify-content-end" style="margin-top:20px">
                            <p style="color: var(--primaryBG);cursor: pointer;" id="reset">Reset Choices</p>
                        </div>
                    </div>
                </div>
                <h6 style="margin-bottom:15px">Additional Information:</h6>
                <div class="card">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">Description: <i id="check-end_date"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <textarea name="description" required class="form-control" id="" cols="5" rows="5"></textarea>
                            </div>
                        </div>


                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">Thumbnail: <i id="check-end_date"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="file" name="thumbnail" required accept="image/*"
                                    class="form-control" id="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end" style="margin-top:20px">
                    <button class="btn-add" id="btn-add-promo">Add promo</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
    
        $('#form-promo').submit(function(e) {
            if ($('input[type="radio"]:checked').length <= 0) {
                e.preventDefault();
                alert('Please select Courses');
            }
        });
        $('#reset').click(function(e) {

            e.preventDefault();
            $('input[type="radio"]').prop('checked', false);


        });
    });
</script>
@include(SchoolFileHelper::$footer)
