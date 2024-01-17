@include('admin.includes.header', ['title' => 'Pending Application of Driving Schools'])
<script>
    $(document).ready(function() {
        $('#table').DataTable();

    });
</script>
<div class="container-fluid" style="padding: 20px;margin-top:60px">
    <div class="row">
        <div class="col-12">
            {{-- <div class="w-100 d-flex justify-content-between table-header-btn">
                <div class="d-flex" style="gap:15px">
                    <button class="btn-outline-light"><i class="fa-solid fa-file-export"></i>Export CSV</button>

                </div>

            </div> --}}
            <table id="table" class="table" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Driving School</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Date Joined</th>
                        <th style="width: 60px">Action</th>

                    </tr>
                <tbody>
                    @foreach ($schools as $school)
                        <tr>
                            <td><img src="/{{ $school->profile_image }}" class="rounded-circle"
                                    style="width: 40px; height: 40px" alt="Avatar" /></td>
                            <td>{{ $school->name }}</td>
                            <td>{{ $school->email }}</td>
                            <td>{{ $school->address }}</td>
                            <td>{{ \Carbon\Carbon::parse($school->date_created)->format('F j, Y') }}</td>
                            <td>

                                <div class="dropdown">
                                    <i class="dropdown-toggle fa-solid fa-gears" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">

                                    </i>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item"
                                                href="{{ route('admin.pending.schools.details', $school->user_id) }}">More
                                                Details</a></li>
                                        <li><a class="dropdown-item" role="button" data-bs-toggle="modal"
                                                data-bs-target="#a{{ $school->user_id }}">Notify</a></li>

                                    </ul>
                                </div>
                            </td>

                        </tr>

                        <div class="modal fade" id="a{{ $school->user_id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="d-flex align-items-center justify-content-between"
                                        style="padding: 25px 25px 0 25px">
                                        <h5 class="" id="">Notify School</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST"
                                            action="{{ route('notify.drivingschool', [
                                                'id' => $school->user_id,
                                            ]) }}"
                                            id="payment-form" style="padding: 0 10px 10px 10px" id="formCancel">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="" class="form-label">Message:</label>
                                                <textarea class="form-control" name="content" id="reason" cols="30" rows="10" required></textarea>
                                            </div>
                                            <button id="btn-form" class="btn btn-primary w-100"
                                                style="background-color: var(--primaryBG)">Notify</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
                </thead>

            </table>

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
@include('admin.includes.footer')
