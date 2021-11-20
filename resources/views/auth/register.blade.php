@extends('layouts.app')

@section('view')
    <div class="view-login">
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
        
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="control-label">Name</label>
        
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
        
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
        
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">E-Mail Address</label>
        
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
        
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
        
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">Password</label>
        
                            <input id="password" type="password" class="form-control" name="password" required>
        
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
        
                        <div class="form-group">
                            <label for="password-confirm" class="control-label">Confirm Password</label>
        
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required><div class="col-md-6">
                        </div>

                        <br>
        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
	<link rel="stylesheet" href="{{ asset('scss/pages/css/login.css') }}">
@endsection

@section('js')
@endsection
