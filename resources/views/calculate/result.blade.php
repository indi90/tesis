@extends('layouts.app')

@push('style-head')
<style>
    .table tbody>tr>td.vert-align{
        vertical-align: middle;
    }
</style>
@endpush

@push('script-head')
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDTp3vvNwILQR8qOSmuZvUAKlpoY5cSc18"></script>
<script>
    var directionDisplay;
    var directionsService = new google.maps.DirectionsService();
    var map;
    function initialize() {
        var latitude = {{ $lat_DC }};
        var longitude = {{ $long_DC }};

        var origin = new google.maps.LatLng(latitude, longitude);

        var mapProp = {
            center: origin,
            zoom:13,
            mapTypeId:google.maps.MapTypeId.ROADMAP
        };
        directionsDisplay = new google.maps.DirectionsRenderer();
        map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
        directionsDisplay.setMap(map);
        calcRoute();

//        function renderDirections(result) {
//            var directionsRenderer = new google.maps.DirectionsRenderer;
//            directionsRenderer.setMap(map);
//            directionsRenderer.setDirections(result);
//        }

//        function requestDirections(start, end) {
//            var directionsService = new google.maps.DirectionsService;
//            directionsService.route({
//                origin: start,
//                destination: end,
//                travelMode: google.maps.DirectionsTravelMode.DRIVING
//            }, function(result) {
//                renderDirections(result);
//            });
//        }

        {{--@foreach($retails as $key => $retail)--}}
            {{--var destination = new google.maps.LatLng({{ $retail->latitude }}, {{ $retail->longitude }});--}}
//            var retail = new google.maps.Marker({
                {{--position: LatLang,--}}
                {{--map: map,--}}
                {{--title: '{{ $retail->label }}',--}}
                {{--icon: 'https://maps.gstatic.com/intl/en_us/mapfiles/markers2/measle_blue.png'--}}
            {{--});--}}
//            calculateAndDisplayRoute(directionsService, directionsDisplay, LatLng, LatLang);
            {{--requestDirections(origin, destination);--}}
        {{--@endforeach--}}
        {{--var marker = new google.maps.Marker({--}}
            {{--position: LatLng,--}}
            {{--map: map,--}}
            {{--title: 'Distribution Center',--}}
            {{--icon: '{{ url('images/office-building.png') }}'--}}
        {{--});--}}
    }

    function calcRoute() {

        var waypts = [];


        @foreach($retails as $key => $retail)
                stop = new google.maps.LatLng({{ $retail->latitude }}, {{ $retail->longitude }});
                waypts.push({
                    location:stop,
                    stopover:true
                });
        @endforeach
        start  = new google.maps.LatLng({{ $lat_DC }}, {{ $long_DC }});
        end = new google.maps.LatLng({{ $lat_DC }}, {{ $long_DC }});

        var request = {
            origin: start,
            destination: end,
            waypoints: waypts,
            optimizeWaypoints: true,
            travelMode: google.maps.DirectionsTravelMode.DRIVING
        };

        directionsService.route(request, function(response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
                var route = response.routes[0];

            }
        });
    }

//    function requestDirections(start, end, map) {
//        var directionsService = new google.maps.DirectionsService;
//        directionsService.route({
//            origin: start,
//            destination: end,
//            travelMode: google.maps.DirectionsTravelMode.DRIVING
//        }, function(result) {
//            renderDirections(result, map);
//        });
//    }

//    function calculateAndDisplayRoute(directionsService, directionsDisplay, origin, destination) {
//        directionsService.route({
//            origin: origin,
//            destination: destination,
//            travelMode: 'DRIVING'
//        }, function(response, status) {
//            if (status === 'OK') {
//                directionsDisplay.setDirections(response);
//            } else {
//                window.alert('Directions request failed due to ' + status);
//            }
//        });
//    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>
@endpush
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="googleMap" style="width:auto;height:400px;"></div>
            </div>
            <div class="col-md-10 col-md-offset-1" style="margin-top: 10px">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th colspan="2" class="text-center">DC Location</th>
                        <th rowspan="2" style="vertical-align: middle;" class="text-center">Retail</th>
                        <th rowspan="2" style="vertical-align: middle;" class="text-center">Track</th>
                        <th rowspan="2" style="vertical-align: middle;" class="text-center">Development Cost (Rp.)</th>
                        <th rowspan="2" style="vertical-align: middle;" class="text-center">Transportation Cost (Rp.)</th>
                        <th rowspan="2" style="vertical-align: middle;" class="text-center">Saving Cost (Rp.)</th>
                        <th rowspan="2" style="vertical-align: middle;" class="text-center">Total Cost (Rp.)</th>
                    </tr>
                    <tr>
                        <th class="text-center">Long</th>
                        <th class="text-center">Lat</th>
                    </tr>
                    </thead>
                    <tbody id="p_scents">
                        <tr>
                            <td>{{ $long_DC }}</td>
                            <td>{{ $lat_DC }}</td>
                            <td>
                                <ul style="margin-left: 0;">
                                    @foreach($retails as $retail)
                                        <li>
                                            {{ $retail->label."(".GetDrivingDistance($lat_DC, $retail->latitude, $long_DC, $retail->longitude)['distance'].")" }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ 'DC->'.$track.'->DC'.' ('.$total_distance.' Km)' }}</td>
                            <td>{{ number_format($development_cost,2,',','.') }}</td>
                            <td>{{ number_format($transportation_cost,2,',','.') }}</td>
                            <td>{{ number_format($saving_cost,2,',','.') }}</td>
                            <td>{{ number_format(($development_cost+$transportation_cost+$saving_cost),2,',','.') }}</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
