@include(SchoolFileHelper::$header, ['title' => 'Update Promo'])
<style>
.btn-update-promo {
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
    <form method="post" id="updatePromo" enctype="multipart/form-data">
        @csrf
        <div class="row">


            <div class="col-lg-2">
                <div class="col-12" style="margin:0 0 30px 0">
                    <h6>Promo Thumbnail</h6>
                </div>
                <img class="img-fluid" style="border-radius: 10px" src="/{{($details->thumbnail)}}" alt="" srcset="">
                <div class="mb-3" style="margin-top: 30px">
                    <input type="file" class="form-control" name="image" />
                </div>
            </div>


            <div class="col-lg-10">


                <h6 style="margin-bottom:15px">Promo details:</h6>




                <div class="card" style="margin: 10px 0 20px 0">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="title" class="form-label">Name: <i id="check-title"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="text" class="form-control" id="title" name="name"
                                    placeholder="Enter title..." required value="{{$details->name}}" />
                                <input type="hidden" class="form-control" id="promo_id" name="promo_id" required
                                    value="{{$details->id}}" />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Price: <i id="check-price"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="number" class="form-control" id="price" name="price"
                                    placeholder="Enter price..." required value="{{$details->price}}" />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start date: <i id="check-start_date"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="datetime-local" class="form-control" id="start_date" name="start_date"
                                    placeholder="Enter start date..." required value="{{$details->start_date}}" />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End date: <i id="check-end_date"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <input type="datetime-local" class="form-control" id="end_date" name="end_date"
                                    placeholder="Enter end date..." required value="{{$details->end_date}}" />
                            </div>
                        </div>
                    </div>
                </div>

                <h6 style="margin-bottom:15px">Promo Items:</h6>

                <div class="card" style="margin: 10px 0 20px 0">
                    <div class="row">
                        @foreach ($school_courses as $course)
                        @if (count($course->variants) == 0)
                        @continue
                        @endif
                        <div class="col-lg-6">
                            <div style="padding:10px;border:1px solid var(--borderColor);margin-bottom:15px;">
                                <h6 style="margin-bottom: 10px">{{ $course->name }}</h6>
                                <div class="row">
                                    @foreach ($course->variants as $variant)
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" value="{{ $variant->id }}" type="radio"
                                                name="{{ $course->id }}" id="{{ $course->id }}"
                                                {{ collect($promo_items)->contains('variant_id', $variant->id) ? 'checked' : '' }}>
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
                    </div>

                </div>
                <h6 style="margin-bottom:15px">Additional Information:</h6>

                <div class="card">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">Description: <i id="check-description"
                                        class="fa-solid fa-check check-label" style=""></i></label>
                                <textarea name="description" class="form-control" id="description" cols="5"
                                    rows="5">{{$details->description}}</textarea>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="d-flex justify-content-end" style="margin-top:20px">


                    <button class="btn-update-promo">Update promo</button>


                </div>

            </div>
        </div>
    </form>
</div>


<script>
$("#updatePromo").submit(function(e) {
    e.preventDefault(); // Prevent the form from submitting in the traditional way

    $.ajax({
        type: "POST",
        url: "{{ route('update.promo')}}",
        contentType: false,
        processData: false,
        data: new FormData(this),
        success: function(response) {
            if (response.code == 200) {
                swal({
                    icon: "success",
                    title: 'Promo Successfully Updated',
                    text: " ",
                    timer: 2000,
                    showConfirmButton: false,
                }).then(function() {
                    window.location.href = "{{ route('index.promo') }}";
                });
            } else {
                alert('heheh error');
            }
        },
        error: function(xhr, status, error) {
            console.log("AJAX Error: " + error);
        }
    });
});
</script>

@include(SchoolFileHelper::$footer)