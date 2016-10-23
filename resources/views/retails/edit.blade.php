    @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">Add Data Retail</div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('retails.update', $retail->id) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                            <input type="text" name="upload_file" value="false" hidden>

                            <div class="form-group{{ $errors->has('label') ? ' has-error' : '' }}">
                                <label for="inputLabel" class="col-sm-2 control-label">Label</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputLabel" name="label" value="{{ old('label', $retail->label) }}">

                                    @if ($errors->has('label'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('label') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('longitude') ? ' has-error' : '' }}">
                                <label for="inputLongitude" class="col-sm-2 control-label">Longitude</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputLongitude" name="longitude" value="{{ old('longitude', $retail->longitude) }}">

                                    @if ($errors->has('longitude'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('longitude') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('latitude') ? ' has-error' : '' }}">
                                <label for="inputLatitude" class="col-sm-2 control-label">Latitude</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="latitude" id="inputLatitude" value="{{ old('latitude', $retail->latitude) }}">

                                    @if ($errors->has('latitude'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('latitude') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            {{--<div class="form-group{{ $errors->has('district') ? ' has-error' : '' }}">--}}
                                {{--<label for="inputDistrict" class="col-sm-2 control-label">District</label>--}}
                                {{--<div class="col-sm-9">--}}
                                    {{--<input type="text" class="form-control" name="district" id="inputDistrict" value="{{ old('district', $retail->district) }}">--}}

                                    {{--@if ($errors->has('district'))--}}
                                        {{--<span class="help-block">--}}
                                            {{--<strong>{{ $errors->first('district') }}</strong>--}}
                                        {{--</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="form-group{{ $errors->has('sub_district') ? ' has-error' : '' }}">--}}
                                {{--<label for="inputSubDistrict" class="col-sm-2 control-label">Sub District</label>--}}
                                {{--<div class="col-sm-9">--}}
                                    {{--<input type="text" class="form-control" name="sub_district" id="inputSubDistrict" value="{{ old('sub_district', $retail->sub_district) }}">--}}

                                    {{--@if ($errors->has('sub_district'))--}}
                                        {{--<span class="help-block">--}}
                                            {{--<strong>{{ $errors->first('sub_district') }}</strong>--}}
                                        {{--</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-9">
                                    <button type="submit" class="btn btn-primary"> Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
