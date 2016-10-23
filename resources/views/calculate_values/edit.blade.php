@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">Edit Data</div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('calculate_values.update', $value->id) }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">Value Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputName" name="name" value="{{ old('name', $value->name) }}" readonly>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
                                <label for="inputValue" class="col-sm-2 control-label">Value</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputValue" name="value" value="{{ old('value', $value->value) }}">

                                    @if ($errors->has('value'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('value') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-9">
                                    <button type="submit" class="btn btn-primary"> Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
