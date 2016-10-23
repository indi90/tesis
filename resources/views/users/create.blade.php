@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">Add Data User</div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('users.store') }}" method="POST">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputName" name="name" value="{{ old('name') }}">

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputEmail" name="email" value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-sm-2 control-label">Password</label>

                                <div class="col-sm-9">
                                    <input id="password" type="password" class="form-control" name="password">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="col-sm-2 control-label">Confirm Password</label>

                                <div class="col-sm-9">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-9 col-md-offset-2">
                                    <div class="checkbox">
                                        <label>
                                            @if(old('is_admin'))
                                                <input type="checkbox" name="is_admin" value="1" checked> Admin
                                            @else
                                                <input type="checkbox" name="is_admin" value="1"> Admin
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            </div>

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
