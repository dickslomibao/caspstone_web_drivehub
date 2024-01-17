@include(SchoolFileHelper::$header, ['title' => 'Realtime Tracking'])

<div class="container-fluid" style="padding:20px;margin-top:60px">


    <div id="map" style="width: 100%;height:calc(100vh - 100px)"></div>


</div>
<div class="modal fade modal-lg" id="scheduleView" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" id="exampleModalLabel">Schedule Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="" style="padding: 20px 7px" id="body">

            </div>
        </div>
    </div>
</div>
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC85qXT_Yw5dwax9Rk9K62DLsxM9vVQWB4&callback=initMap&v=weekly"
    defer></script>
<script>
    let infoWindow;
    let geocoder;
    let map;
    let address;
    let lat;
    let long;
    let sid = 0;
    const markers = {};

    function initMap() {
        const myLatlng = {
            lat: 15.97611,
            lng: 120.57111
        };
        geocoder = new google.maps.Geocoder();
        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 10,
            center: myLatlng,
        });

        console.log('tracking_' + user_current_id);

        pusher.subscribe('tracking_' + user_current_id).bind('location', function(element) {
            console.log(element);
            updateMarker(element);
        });

    }

    function updateMarker(data) {
        const {
            schedule_id,
            lat,
            long
        } = data;

        if (sid == 0) {
            sid = parseInt(schedule_id);
        }
        if (sid == parseInt(schedule_id)) {
            map.setCenter({
                lat: lat,
                lng: long,
            });
            map.setZoom(18);
        }
        if (markers[schedule_id]) {
            // If the marker exists, update its position
            markers[schedule_id].setPosition({
                lat,
                lng: long
            });
        } else {
            // If the marker doesn't exist, create a new marker
            const marker = new google.maps.Marker({
                position: {
                    lat,
                    lng: long
                },
                map,
                title: `Schedule ID: ${schedule_id}`,
            });

            marker.addListener('click', function() {
                sid = parseInt(schedule_id);
                $('#scheduleView').modal('show');
                $('#body').html(`<center><h5>Loading...</h5></center>`);
                $.ajax({
                    method: 'POST',
                    url: "{{ route('view.sched') }}",
                    data: {
                        'id': schedule_id
                    },
                    success: function(response) {
                        console.log(response);
                        $('#body').html(response);
                    }
                });
            });
            // Store the marker in the markers object
            markers[schedule_id] = marker;
        }
    }
    // async function geocode(request) {
    //     await geocoder
    //         .geocode(request)
    //         .then((result) => {
    //             const {
    //                 results
    //             } = result;
    //             const position = request.location;
    //             address = result.results[1].formatted_address;
    //             console.log(result);
    //             if (infoWindow) {
    //                 infoWindow.close();
    //             }
    //             infoWindow = new google.maps.InfoWindow({
    //                 position: position,
    //             });

    //             infoWindow.setContent(
    //                 address,
    //             );
    //             console.log(lat);
    //             console.log(long);
    //             infoWindow.open(map);
    //             map.setCenter(position);
    //             map.setZoom(15);
    //             $('#display-address').html("Selected Address: " + address);
    //             $('#address').val(address);
    //         })
    //         .catch((e) => {
    //             alert("Geocode was not successful for the following reason: " + e);
    //         });
    // }
    window.initMap = initMap;
</script>
@include(SchoolFileHelper::$footer)
