<style>
    .btn-add-order {
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

@include(SchoolFileHelper::$header, ['title' => 'Make an order'])
<div class="container-fluid" style="padding: 20px;margin-top:60px">
    <form class="form" method="POST"
        action="{{ route('create.makeorder', [
            'student_id' => $student_id,
        ]) }}">
        @csrf
        <div class="d-flex align-items-center justify-content-between" style="margin-bottom:20px">
            <h6>Select Course:</h6>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="promo_toggle" id="promo-toggle">
                <label class="form-check-label" for="flexCheckDefault">
                    Promo
                </label>
            </div>
        </div>
        <div class="card" id="promo-list" style="display: none">
            <div class="row">

                @forelse ($promos as $promo)
                    <div class="col-lg-4">

                        <div style="padding:15px;border:1px solid var(--borderColor);margin:0 0 15px 0;">
                            <input class="form-check-input" name="promo" value="{{ $promo->id }}" type="radio">
                            <br>
                            <img style="margin:10px 0 0 0;object-fit:cover;border-radius:5px" height="200"
                                width="100%" src="/{{ $promo->thumbnail }}">
                            <h6 style="margin:10px 0 5px 0">Name: {{ $promo->name }}</h6>
                            <h6 style="margin:0 0 15px 0">Price: {{ number_format($promo->price, 2) }} php</h6>
                            <h6>Items:</h6>

                            @foreach ($promo->data as $item)
                                <h6 style="margin:5px 0 0 0">{{ $item['course']->name }}
                                    ({{ $item['course']->variants[0]->duration }}) hrs</h6>
                            @endforeach
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
        <div class="card" id="course-list">

            <div class="row">
                @foreach ($school_courses as $course)
                    @if (count($course->variants) == 0)
                        @php
                            continue;
                        @endphp
                    @endif
                    <div class="col-lg-6">
                        <div style="padding:15px;border:1px solid var(--borderColor);margin-bottom:15px;">
                            <h6 style="margin-bottom: 10px">{{ $course->name }}</h6>
                            <div class="row">
                                @foreach ($course->variants as $variant)
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" value="{{ $variant->id }}" type="radio"
                                                name="{{ $course->id }}" id="{{ $course->id }}">
                                            <label class="form-check-label" for="{{ $course->id }}">
                                                {{ $variant->duration }} hrs (Php
                                                {{ number_format($variant->price, 2) }})
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
        <div class="d-flex justify-content-end" style="margin-top:20px">
            <p style="color: var(--primaryBG);cursor: pointer;" id="reset">Reset Choices</p>
        </div>
        <h6 style="margin: 15px 0 15px 0">Payment Method:</h6>

        <div class="card">
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-check">
                        <input class="form-check-input" checked value="1" type="radio" name="payment">
                        <label class="form-check-label">
                            Cash
                        </label>
                    </div>
                </div>
                {{-- <div class="col-lg-4">
                    <div class="form-check">
                        <input class="form-check-input" value="1" type="radio" name="payment">
                        <label class="form-check-label">
                            GCash
                        </label>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-check">
                        <input class="form-check-input" value="1" type="radio" name="payment">
                        <label class="form-check-label">
                            Credit Card
                        </label>
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="d-flex justify-content-end" style="margin-top:40px">
            <button class="btn-add-order">Make an Order</button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        $('#promo-toggle').change(function() {
            $('input[type="radio"]').prop('checked', false);
            if (this.checked) {
                $('#promo-list').css('display', 'block');
                $('#course-list').css('display', 'none');
            } else {
                $('#course-list').css('display', 'block');
                $('#promo-list').css('display', 'none');
            }
        });
        $('#reset').click(function(e) {
            e.preventDefault();
            $('input[type="radio"]').prop('checked', false);


        });
    });
</script>

@include(SchoolFileHelper::$footer)
