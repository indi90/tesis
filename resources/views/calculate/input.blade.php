@extends('layouts.app')

@push('script-body')
<script>
    $(document).ready(function () {
        var scntDiv = $('#p_scents');
        var i = $('#p_scents tr').length + 1;

        $('#addScnt').click(function () {
            scntDiv.append('<tr>' +
                    '<td><select name="retails[]" class="form-control"><option></option>' +
                    '@foreach($retails as $retail)' +
                    '<option value="{{ $retail->id }}">{{ $retail->label }}</option> @endforeach </select></td>' +
                    '<td><input type="text" name="rice_demands[]" class="form-control"></td>' +
                    '<td><input type="text" name="sugar_demands[]" class="form-control"></td>' +
                    '<td><input type="text" name="oil_demands[]" class="form-control"></td>' +
                    '<td width="10"><button type="button" class="btn btn-warning btn-circle pull-right btn-sm" id="remScnt">Del</button></td>' +
                    '</tr>');
            i++;
            return false;
        });

        //Remove button
        $(document).on('click', '#remScnt', function (e) {
            console.log(e);
            if (i > 2) {
                $(this).closest('tr').remove();
            }
            return false;
        });
    });
</script>
@endpush

@push('script-head')
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDTp3vvNwILQR8qOSmuZvUAKlpoY5cSc18"></script>
<script>
    function initialize() {
        var latitude = -7.7955798;
        var longitude = 110.3694896;

        var LatLng = new google.maps.LatLng(latitude, longitude);

        var mapProp = {
            center: LatLng,
            zoom:13,
            mapTypeId:google.maps.MapTypeId.ROADMAP
        };
        var map=new google.maps.Map(document.getElementById("googleMap"), mapProp);

        @foreach($retails as $retail)
            var LatLang = new google.maps.LatLng({{ $retail->latitude }}, {{ $retail->longitude }});
            var retail = new google.maps.Marker({
                position: LatLang,
                map: map,
                title: '{{ $retail->label }}',
                icon: 'https://maps.gstatic.com/intl/en_us/mapfiles/markers2/measle_blue.png'
            });
        @endforeach
        var marker = new google.maps.Marker({
            position: LatLng,
            map: map,
            title: 'Drag Me!',
            draggable: true,
            icon: '{{ url('images/office-building.png') }}'
        });
        google.maps.event.addListener(marker, 'dragend', function(event) {

            document.getElementById('inputLatitude').value = event.latLng.lat();
            document.getElementById('inputLongitude').value = event.latLng.lng();



        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>
@endpush
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="googleMap" style="width:auto;height:400px;"></div>
            </div>
            <div class="col-md-8 col-md-offset-2">
                <form class="form-horizontal" action="{{ route('calculate.store') }}" method="POST">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-2">
                            <label class="control-label">Distribution Center</label>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('longitude') ? ' has-error' : '' }}">
                        <label for="inputLongitude" class="col-sm-2 control-label">Longitude</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputLongitude" name="longitude" value="{{ old('longitude') }}">

                            @if ($errors->has('longitude'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('longitude') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('latitude') ? ' has-error' : '' }}">
                        <label for="inputLatitude" class="col-sm-2 control-label">Latitude</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="latitude" id="inputLatitude" value="{{ old('latitude') }}">

                            @if ($errors->has('latitude'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('latitude') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                        <label for="inputPrice" class="col-sm-2 control-label">The Land Price</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="price" id="inputPrice" value="{{ old('price') }}">

                            @if ($errors->has('price'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-2">
                            <label class="control-label">Distribution Center Capacity</label>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('rice') ? ' has-error' : '' }}">
                        <label for="inputRice" class="col-sm-2 control-label">Rice</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" class="form-control" name="rice" id="inputRice" value="{{ old('rice') }}">
                                <span class="input-group-addon">Kg</span>
                            </div>

                            @if ($errors->has('rice'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('rice') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('sugar') ? ' has-error' : '' }}">
                        <label for="inputSugar" class="col-sm-2 control-label">Sugar</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" class="form-control" name="sugar" id="inputSugar" value="{{ old('sugar') }}">
                                <span class="input-group-addon">Kg</span>
                            </div>

                            @if ($errors->has('sugar'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('sugar') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('cooking_oil') ? ' has-error' : '' }}">
                        <label for="inputCookingOil" class="col-sm-2 control-label">Cooking Oil</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" class="form-control" name="cooking_oil" id="inputCookingOil" value="{{ old('cooking_oil') }}">
                                <span class="input-group-addon">Ltr</span>
                            </div>

                            @if ($errors->has('cooking_oil'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('cooking_oil') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-2">
                            <label class="control-label">Retail & Demand</label>
                        </div>
                    </div>
                    <div class="form-group">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @for ($i = 0; $i < count(old('retails')); $i++)
                                        <li>{{ $errors->first('retails.'.$i) }}</li>
                                        <li>{{ $errors->first('rice_demands.'.$i) }}</li>
                                        <li>{{ $errors->first('sugar_demands.'.$i) }}</li>
                                        <li>{{ $errors->first('oil_demands.'.$i) }}</li>
                                    @endfor
                                </ul>
                            </div>
                        @endif
                        @include('flash::message')
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Retail Name</th>
                                <th>Rice Demand</th>
                                <th>Sugar Demand</th>
                                <th>Cooking Oil Demand</th>
                            </tr>
                            </thead>
                            <tbody id="p_scents">
                                <tr>
                                    <td>
                                        <select class="form-control" name="retails[]">
                                            <option></option>
                                            @foreach($retails as $retail)
                                                <option value="{{ $retail->id }}">{{ $retail->label }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="rice_demands[]">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="sugar_demands[]">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="oil_demands[]">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-9">
                            <button type="submit" class="btn btn-primary"> Calculate</button>
                            <button type="button" class="btn btn-success" id="addScnt"> Add Row</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
